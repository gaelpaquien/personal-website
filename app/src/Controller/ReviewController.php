<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[\Symfony\Component\Routing\Annotation\Route('/', name: 'app_review_')]
class ReviewController extends AbstractController
{
    #[Route([
        'fr' => '/avis/creation',
        'en' => '/reviews/create',
    ], name: 'create', options: ['sitemap' => ['priority' => 0.8, 'changefreq' => 'monthly']])]
    public function create(): Response
    {
        return $this->render('pages/reviews/create.html.twig');
    }
}
