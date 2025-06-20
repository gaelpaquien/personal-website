<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MailService;
use App\Service\ContentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/', name: 'app_main_')]
class MainController extends AbstractController
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly MailService $mailService,
        private readonly TranslatorInterface $translator
    ) {}

    #[Route('/', name: 'root')]
    public function root(Request $request): Response
    {
        $locale = $request->getSession()->get('_locale') ??
            $request->getPreferredLanguage(['fr', 'en']) ??
            'fr';

        return $this->redirectToRoute('app_main_index', ['_locale' => $locale]);
    }

    #[Route([
        'fr' => '/fr',
        'en' => '/en',
    ], name: 'index', options: ['sitemap' => ['priority' => 1.0, 'changefreq' => 'daily']], methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $locale = $request->getSession()->get('_locale', 'fr');
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            if ($contactForm->isSubmitted()) {
                if ($contactForm->isValid()) {
                    $formData = $contactForm->getData();

                    if ($this->mailService->sendContactEmail($formData, $locale)) {
                        return $this->json([
                            'success' => true,
                            'message' => $this->translator->trans('form.contact.success', [], null, $locale)
                        ]);
                    } else {
                        return $this->json([
                            'success' => false,
                            'message' => $this->translator->trans('form.contact.error', [], null, $locale)
                        ]);
                    }
                } else {
                    $errors = [];
                    foreach ($contactForm->getErrors(true) as $error) {
                        $field = $error->getOrigin()->getName();
                        $errors[$field][] = $error->getMessage();
                    }

                    return $this->json([
                        'success' => false,
                        'errors' => $errors
                    ]);
                }
            }
        }

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $formData = $contactForm->getData();

            if ($this->mailService->sendContactEmail($formData, $locale)) {
                $this->addFlash('success', $this->translator->trans('form.contact.success', [], null, $locale));

                return $this->redirectToRoute('app_main_index', [
                    '_locale' => $locale,
                    '_fragment' => 'home-contact'
                ]);
            } else {
                $this->addFlash('error', $this->translator->trans('form.contact.error', [], null, $locale));
            }
        }

        return $this->render('pages/index.html.twig', [
            'projects' => $this->contentService->getAllProjects($locale),
            'reviews' => $this->contentService->getAllReviews($locale),
            'contactForm' => $contactForm->createView(),
        ]);
    }

    #[Route([
        'fr' => '/fr/mentions-legales',
        'en' => '/en/legal-notice',
    ], name: 'legal_notice', options: ['sitemap' => ['priority' => 0.5, 'changefreq' => 'monthly']])]
    public function legalNotice(): Response
    {
        return $this->render('pages/legal_notice.html.twig');
    }

    #[Route([
        'fr' => '/fr/politique-de-confidentialite',
        'en' => '/en/privacy-policy',
    ], name: 'privacy_policy', options: ['sitemap' => ['priority' => 0.5, 'changefreq' => 'monthly']])]
    public function privacyPolicy(): Response
    {
        return $this->render('pages/privacy_policy.html.twig');
    }

    #[Route([
        'fr' => '/fr/plan-du-site',
        'en' => '/en/sitemap',
    ], name: 'sitemap', options: ['sitemap' => ['priority' => 0.6, 'changefreq' => 'monthly']])]
    public function sitemap(Request $request): Response
    {
        $xml = \simplexml_load_file($this->getParameter('kernel.project_dir') . '/public/sitemap.default.xml');
        $locale = $request->getSession()->get('_locale', 'fr');

        $urls = [];
        foreach ($xml->url as $urlElement) {
            $url = (string) $urlElement->loc;

            if (isset($urlElement->children('xhtml', true)->link)) {
                foreach ($urlElement->children('xhtml', true)->link as $link) {
                    if ((string) $link->attributes()['hreflang'] === $locale) {
                        $url = (string) $link->attributes()['href'];
                        break;
                    }
                }
            }

            $urls[] = $url;
        }

        return $this->render('pages/sitemap.html.twig', [
            'urls' => $urls,
        ]);
    }
}