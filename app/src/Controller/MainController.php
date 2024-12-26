<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_main_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'index', options: ['sitemap' => ['priority' => 1.0, 'changefreq' => 'daily']])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route([
        'fr' => '/mentions-legales',
        'en' => '/legal-notice',
    ], name: 'legal_notice', options: ['sitemap' => ['priority' => 0.5, 'changefreq' => 'monthly']])]
    public function legalNotice(): Response
    {
        return $this->render('main/legal_notice.html.twig');
    }

    #[Route([
        'fr' => '/politique-de-confidentialite',
        'en' => '/privacy-policy',
    ], name: 'privacy_policy', options: ['sitemap' => ['priority' => 0.5, 'changefreq' => 'monthly']])]
    public function privacyPolicy(): Response
    {
        return $this->render('main/privacy_policy.html.twig');
    }

    #[Route([
        'fr' => '/plan-du-site',
        'en' => '/sitemap',
    ], name: 'sitemap', options: ['sitemap' => ['priority' => 0.6, 'changefreq' => 'monthly']])]
    public function sitemap(): Response
    {
        $xml = \simplexml_load_file($this->getParameter('kernel.project_dir') . '/public/sitemap.default.xml');

        $urls = [];
        foreach ($xml->url as $urlElement) {
            $urls[] = (string) $urlElement->loc;
        }

        return $this->render('main/sitemap.html.twig', [
            'urls' => $urls,
        ]);
    }
}
