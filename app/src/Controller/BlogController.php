<?php

namespace App\Controller;

use App\Exception\RedirectArticleException;
use App\Service\ContentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[\Symfony\Component\Routing\Annotation\Route('/', name: 'app_blog_')]
class BlogController extends AbstractController
{
    public function __construct(private readonly ContentService $contentService)
    {}

    #[Route([
        'fr' => '/fr/blog',
        'en' => '/en/blog',
    ], name: 'index', options: ['sitemap' => ['priority' => 0.9, 'changefreq' => 'daily']])]
    public function index(Request $request): Response
    {
        $locale = $request->getSession()->get('_locale', 'fr');

        $articles = $this->contentService->getAllArticles($locale);

        return $this->render('pages/blog/index.html.twig', compact('articles'));
    }

    #[Route([
        'fr' => '/fr/blog/{slug}',
        'en' => '/en/blog/{slug}',
    ], name: 'show', options: ['sitemap' => false])]
    public function show(string $slug, Request $request): Response
    {
        $locale = $request->getSession()->get('_locale', 'fr');

        try {
            $article = $this->contentService->getArticleBySlug($slug, $locale);
        } catch (RedirectArticleException $e) {
            return $this->redirectToRoute('app_blog_show', ['slug' => $e->slug], 301);
        }

        return $this->render('pages/blog/show.html.twig', compact('article'));
    }
}