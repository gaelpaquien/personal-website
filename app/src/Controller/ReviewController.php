<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Traits\FormHandlerTrait;
use App\Form\ReviewType;
use App\Service\RecaptchaService;
use App\Service\ReviewService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

#[Route('/', name: 'app_review_')]
class ReviewController extends AbstractController
{
    use FormHandlerTrait;

    public function __construct(
        private readonly ReviewService $reviewService,
        private readonly TranslatorInterface $translator,
        private readonly LoggerInterface $logger,
        private readonly RateLimiterFactory $reviewFormLimiter,
        private readonly RecaptchaService $recaptchaService
    ) {}

    #[Route([
        'fr' => '/fr/avis/creation',
        'en' => '/en/reviews/create',
    ], name: 'create', options: ['sitemap' => ['priority' => 0.8, 'changefreq' => 'monthly']], methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $locale = $request->getSession()->get('_locale', 'fr');
        $reviewForm = $this->createForm(ReviewType::class);
        $reviewForm->handleRequest($request);

        $rateLimitStatus = $this->getRateLimiterStatus($request, $this->reviewFormLimiter, 'review');

        $ajaxResponse = $this->handleForm(
            $request,
            $reviewForm,
            fn($formData) => $this->processReview($formData, $locale),
            $locale,
            'form.review.success',
            'form.review.error',
            $this->reviewFormLimiter,
            'review',
        );

        if ($ajaxResponse) {
            return $ajaxResponse;
        }

        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {
            $rateLimitResponse = $this->checkRateLimit($request, $this->reviewFormLimiter, 'review', $locale);
            if ($rateLimitResponse) {
                return $this->redirectToRoute('app_review_create', ['_locale' => $locale]);
            }

            try {
                $this->processReview($reviewForm->getData(), $locale);
                $this->addFlash('success', $this->translator->trans('form.review.success', [], null, $locale));

                return $this->redirectToRoute('app_review_create', ['_locale' => $locale]);
            } catch (Exception) {
                $this->logger->error('Form review submission failed');
                $this->addFlash('error', $this->translator->trans('form.review.error', [], null, $locale));
            } catch (Throwable) {
                $this->logger->error('Unexpected error during review submission');
                $this->addFlash('error', $this->translator->trans('form.review.error', [], null, $locale));
            }
        }

        return $this->render('pages/post-review.html.twig', [
            'reviewForm' => $reviewForm->createView(),
            'rateLimited' => $rateLimitStatus['is_limited'],
            'retryAfter' => max(0, $rateLimitStatus['retry_after']),
            'google_recaptcha_site_key' => $this->getParameter('google_recaptcha_site_key')
        ]);
    }

    private function processReview(array $formData, string $locale): array
    {
        return $this->reviewService->createReviewWithNotification($formData, $locale);
    }
}