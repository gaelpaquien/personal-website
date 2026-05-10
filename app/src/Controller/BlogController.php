<?php

namespace App\Controller;

use App\Exception\RedirectArticleException;
use App\Service\ContentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_blog_')]
class BlogController extends AbstractController
{
    public function __construct(private readonly ContentService $contentService)
    {}

    #[Route('/blog', name: 'index', options: ['sitemap' => ['priority' => 0.9, 'changefreq' => 'daily']])]
    public function index(): Response
    {
        $articles = $this->contentService->getAllArticles();

        return $this->render('pages/blog/index.html.twig', compact('articles'));
    }

    #[Route('/blog/{slug}', name: 'show', options: ['sitemap' => false])]
    public function show(string $slug): Response
    {
        try {
            $article = $this->contentService->getArticleBySlug($slug);
        } catch (RedirectArticleException $e) {
            return $this->redirectToRoute('app_blog_show', ['slug' => $e->slug], 301);
        }

        return $this->render('pages/blog/show.html.twig', compact('article'));
    }
}
