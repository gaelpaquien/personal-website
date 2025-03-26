<?php

namespace App\Controller;

use App\Service\StaticData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[\Symfony\Component\Routing\Annotation\Route('/', name: 'app_blog_')]
class BlogController extends AbstractController
{
    #[Route([
        'fr' => '/blog',
        'en' => '/blog',
    ], name: 'index', options: ['sitemap' => ['priority' => 0.8, 'changefreq' => 'weekly']])]
    public function index(StaticData $staticData): Response
    {
        $posts = $staticData->getBlogPosts();

        usort($posts, function($a, $b) {
            $dateA = $a['updated_at'] ?? $a['created_at'];
            $dateB = $b['updated_at'] ?? $b['created_at'];

            return strtotime($dateB) - strtotime($dateA);
        });

        return $this->render('main/blog/index.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route([
        'fr' => '/blog/{slug}',
        'en' => '/blog/{slug}',
    ], name: 'show', options: ['sitemap' => ['priority' => 0.8, 'changefreq' => 'weekly']])]
    public function show(string $slug, StaticData $staticData): Response
    {
        return $this->render('main/blog/show.html.twig', [
            'post' => $staticData->getBlogPostDetails($slug)
        ]);
    }
}