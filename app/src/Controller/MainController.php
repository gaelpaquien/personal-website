<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Traits\FormHandlerTrait;
use App\Form\ContactType;
use App\Service\ContentService;
use App\Service\MailService;
use App\Service\RecaptchaService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/', name: 'app_main_')]
class MainController extends AbstractController
{
    use FormHandlerTrait;

    public function __construct(
        private readonly ContentService $contentService,
        private readonly MailService $mailService,
        private readonly TranslatorInterface $translator,
        private readonly LoggerInterface $logger,
        private readonly RateLimiterFactory $contactFormLimiter,
        private readonly RecaptchaService $recaptchaService
    ) {}

    #[Route('/', name: 'index', options: ['sitemap' => ['priority' => 1.0, 'changefreq' => 'daily']], methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        $rateLimitStatus = $this->getRateLimiterStatus($request, $this->contactFormLimiter, 'contact');

        $ajaxResponse = $this->handleForm(
            $request,
            $contactForm,
            fn($formData) => $this->processContact($formData),
            'form.contact.success',
            'form.contact.error',
            $this->contactFormLimiter,
            'contact'
        );

        if ($ajaxResponse) {
            return $ajaxResponse;
        }

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $rateLimitResponse = $this->checkRateLimit($request, $this->contactFormLimiter, 'contact');
            if ($rateLimitResponse) {
                return $this->redirectToRoute('app_main_index', [
                    '_fragment' => 'home-contact'
                ]);
            }

            try {
                $this->processContact($contactForm->getData());
                $this->addFlash('success', $this->translator->trans('form.contact.success'));

                return $this->redirectToRoute('app_main_index', [
                    '_fragment' => 'home-contact'
                ]);
            } catch (Exception) {
                $this->logger->error('Classic form contact submission failed');
                $this->addFlash('error', $this->translator->trans('form.contact.error'));
            }
        }

        return $this->render('pages/index.html.twig', [
            'projects' => $this->contentService->getAllProjects(),
            'reviews' => $this->contentService->getAllReviews(),
            'contactForm' => $contactForm->createView(),
            'rateLimited' => $rateLimitStatus['is_limited'],
            'retryAfter' => max(0, $rateLimitStatus['retry_after']),
            'google_recaptcha_site_key' => $this->getParameter('google_recaptcha_site_key')
        ]);
    }

    private function processContact(array $formData): array
    {
        $success = $this->mailService->sendContactEmail($formData);

        if (!$success) {
            throw new Exception('Contact email sending failed');
        }

        return ['success' => true];
    }

    #[Route('/mentions-legales', name: 'legal_notice', options: ['sitemap' => ['priority' => 0.5, 'changefreq' => 'monthly']])]
    public function legalNotice(): Response
    {
        return $this->render('pages/legal_notice.html.twig');
    }

    #[Route('/politique-de-confidentialite', name: 'privacy_policy', options: ['sitemap' => ['priority' => 0.5, 'changefreq' => 'monthly']])]
    public function privacyPolicy(): Response
    {
        return $this->render('pages/privacy_policy.html.twig');
    }

    #[Route('/plan-du-site', name: 'sitemap', options: ['sitemap' => ['priority' => 0.6, 'changefreq' => 'monthly']])]
    public function sitemap(): Response
    {
        $xml = \simplexml_load_file($this->getParameter('kernel.project_dir') . '/public/sitemap.default.xml');

        $urls = [];
        foreach ($xml->url as $urlElement) {
            $urls[] = (string) $urlElement->loc;
        }

        return $this->render('pages/sitemap.html.twig', [
            'urls' => $urls,
        ]);
    }
}
