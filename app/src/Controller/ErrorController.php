<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

class ErrorController extends AbstractController
{
    public function show(FlattenException $exception): Response
    {
        $statusCode = $exception->getStatusCode();

        try {
            return $this->render("bundles/TwigBundle/Exception/error{$statusCode}.html.twig");
        } catch (\Exception $e) {
            return $this->render('bundles/TwigBundle/Exception/error.html.twig');
        }
    }
}