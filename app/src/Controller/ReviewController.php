<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ReviewType;
use App\Service\MailService;
use App\Service\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/', name: 'app_review_')]
class ReviewController extends AbstractController
{
    public function __construct(
        private readonly ReviewService $reviewService,
        private readonly TranslatorInterface $translator,
        private readonly MailService $mailService
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

        if ($request->isXmlHttpRequest()) {
            if ($reviewForm->isSubmitted()) {
                if ($reviewForm->isValid()) {
                    $formData = $reviewForm->getData();

                    if ($this->reviewService->createReview($formData, $locale) && $this->mailService->sendReviewNotificationEmail($formData, $locale)) {
                        return $this->json([
                            'success' => true,
                            'message' => $this->translator->trans('form.review.success', [], null, $locale)
                        ]);
                    } else {
                        return $this->json([
                            'success' => false,
                            'message' => $this->translator->trans('form.review.error', [], null, $locale)
                        ]);
                    }
                } else {
                    $errors = [];
                    foreach ($reviewForm->getErrors(true) as $error) {
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

        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {
            $formData = $reviewForm->getData();

            if ($this->reviewService->createReview($formData, $locale) && $this->mailService->sendReviewNotificationEmail($formData, $locale)) {
                $this->addFlash('success', $this->translator->trans('form.review.success', [], null, $locale));

                return $this->redirectToRoute('app_review_create', [
                    '_locale' => $locale
                ]);
            } else {
                $this->addFlash('error', $this->translator->trans('form.review.error', [], null, $locale));
            }
        }

        return $this->render('pages/post-review.html.twig', [
            'reviewForm' => $reviewForm->createView(),
        ]);
    }
}