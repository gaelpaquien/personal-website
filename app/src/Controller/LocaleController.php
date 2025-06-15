<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class LocaleController extends AbstractController
{
    #[Route([
        'fr' => '/changement-de-langue/{locale}',
        'en' => '/change-language/{locale}',
    ], name: 'app_change_locale')]
    public function changeLocale($locale, Request $request, RouterInterface $router): RedirectResponse
    {
        $request->getSession()->set('_locale', $locale);

        $referer = $request->headers->get('referer');

        if ($referer) {
            $refererPath = parse_url($referer, PHP_URL_PATH);

            try {
                $routeInfo = $router->match($refererPath);

                $newRouteParams = array_merge($routeInfo, ['_locale' => $locale]);
                unset($newRouteParams['_controller'], $newRouteParams['_route']);

                $newUrl = $this->generateUrl($routeInfo['_route'], $newRouteParams);
                return $this->redirect($newUrl);

            } catch (ResourceNotFoundException | MethodNotAllowedException $e) {
            }
        }

        return $this->redirectToRoute('app_main_index', ['_locale' => $locale]);
    }
}