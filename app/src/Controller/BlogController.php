<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[\Symfony\Component\Routing\Annotation\Route('/', name: 'app_blog_')]
class BlogController extends AbstractController
{
    #[Route([
        'fr' => '/blog',
        'en' => '/blog',
    ], name: 'index', options: ['sitemap' => ['priority' => 0.8, 'changefreq' => 'monthly']])]
    public function create(): Response
    {
        return $this->render('main/blog/index.html.twig');
    }
}
