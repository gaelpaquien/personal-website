<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ContentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_main_')]
class MainController extends AbstractController
{
    public function __construct(private readonly ContentService $contentService)
    {}

    #[Route('/', name: 'index', options: ['sitemap' => ['priority' => 1.0, 'changefreq' => 'daily']])]
    public function index(Request $request): Response
    {
        $locale = $request->getSession()->get('_locale', 'fr');

        return $this->render('pages/index.html.twig', [
            'projects' => $this->contentService->getAllProjects($locale),
            'reviews' => $this->contentService->getAllReviews($locale),
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
