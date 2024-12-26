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

        // Get the referer URL from the request headers
        $referer = $request->headers->get('referer');

        if ($referer) {
            // Extract the path from the referer URL
            $refererPath = parse_url($referer, PHP_URL_PATH);

            try {
                // Match the referer path to a route
                $routeInfo = $router->match($refererPath);

                // Merge the new locale into the route parameters
                $newRouteParams = array_merge($routeInfo, ['_locale' => $locale]);

                // Remove the '_controller' and '_route' parameters as they are not needed for URL generation
                unset($newRouteParams['_controller'], $newRouteParams['_route']);

                // Special handling for the homepage to prevent adding _locale parameter
                if ($routeInfo['_route'] === 'app_main_index') {
                    return $this->redirectToRoute('app_main_index');
                }

                // Generate the new URL with the updated locale and redirect to this new URL
                $newUrl = $this->generateUrl($routeInfo['_route'], $newRouteParams);
                return $this->redirect($newUrl);
            } catch (ResourceNotFoundException | MethodNotAllowedException $e) {
                // If the referer route is not found or method is not allowed, fall back to the home
            }
        }

        // Redirect to the home if no referer or error in matching
        return $this->redirectToRoute('app_main_index');
    }
}
