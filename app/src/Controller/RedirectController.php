<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
    #[Route('/cv', name: 'app_short_cv')]
    public function cv(): BinaryFileResponse
    {
        $path = $this->getParameter('kernel.project_dir') . '/assets/docs/cv.pdf';

        return $this->file($path, 'CV_Gael_Paquien.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/malt', name: 'app_short_malt')]
    public function malt(): RedirectResponse
    {
        return $this->redirect('https://www.malt.fr/profile/gaelpaquien');
    }

    #[Route('/rdv', name: 'app_short_rdv')]
    public function rdv(): RedirectResponse
    {
        return $this->redirect('https://calendly.com/gaelpaquien/meeting');
    }

    #[Route('/fr', name: 'app_legacy_fr_home')]
    #[Route('/en', name: 'app_legacy_en_home')]
    public function legacyHome(): RedirectResponse
    {
        return $this->redirectToRoute('app_main_index', [], 301);
    }

    #[Route('/fr/blog', name: 'app_legacy_fr_blog_index')]
    #[Route('/en/blog', name: 'app_legacy_en_blog_index')]
    public function legacyBlogIndex(): RedirectResponse
    {
        return $this->redirectToRoute('app_blog_index', [], 301);
    }

    #[Route('/fr/blog/{slug}', name: 'app_legacy_fr_blog_show')]
    #[Route('/en/blog/{slug}', name: 'app_legacy_en_blog_show')]
    public function legacyBlogShow(string $slug): RedirectResponse
    {
        return $this->redirectToRoute('app_blog_show', ['slug' => $slug], 301);
    }

    #[Route('/fr/mentions-legales', name: 'app_legacy_fr_legal_notice')]
    #[Route('/en/legal-notice', name: 'app_legacy_en_legal_notice')]
    public function legacyLegalNotice(): RedirectResponse
    {
        return $this->redirectToRoute('app_main_legal_notice', [], 301);
    }

    #[Route('/fr/politique-de-confidentialite', name: 'app_legacy_fr_privacy_policy')]
    #[Route('/en/privacy-policy', name: 'app_legacy_en_privacy_policy')]
    public function legacyPrivacyPolicy(): RedirectResponse
    {
        return $this->redirectToRoute('app_main_privacy_policy', [], 301);
    }

    #[Route('/fr/plan-du-site', name: 'app_legacy_fr_sitemap')]
    #[Route('/en/sitemap', name: 'app_legacy_en_sitemap')]
    public function legacySitemap(): RedirectResponse
    {
        return $this->redirectToRoute('app_main_sitemap', [], 301);
    }

    #[Route('/fr/avis/creation', name: 'app_legacy_fr_review_create')]
    #[Route('/en/reviews/create', name: 'app_legacy_en_review_create')]
    public function legacyReviewCreate(): RedirectResponse
    {
        return $this->redirectToRoute('app_review_create', [], 301);
    }

    #[Route('/changement-de-langue/{locale}', name: 'app_legacy_fr_change_locale', requirements: ['locale' => 'fr|en'])]
    #[Route('/change-language/{locale}', name: 'app_legacy_en_change_locale', requirements: ['locale' => 'fr|en'])]
    public function legacyChangeLocale(): RedirectResponse
    {
        return $this->redirectToRoute('app_main_index', [], 301);
    }
}
