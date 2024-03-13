<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_main_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'index', options: ['sitemap' => ['priority' => 1.0, 'changefreq' => 'daily']])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/mentions-legales', name: 'legal_notice', options: ['sitemap' => ['priority' => 0.7, 'changefreq' => 'monthly']])]
    public function legalNotice(): Response
    {
        return $this->render('main/legal_notice.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/politique-de-confidentialite', name: 'privacy_policy', options: ['sitemap' => ['priority' => 0.7, 'changefreq' => 'monthly']])]
    public function privacyPolicy(): Response
    {
        return $this->render('main/privacy_policy.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/cgu', name: 'terms_of_use', options: ['sitemap' => ['priority' => 0.7, 'changefreq' => 'monthly']])]
    public function termsOfUse(): Response
    {
        return $this->render('main/terms_of_use.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
