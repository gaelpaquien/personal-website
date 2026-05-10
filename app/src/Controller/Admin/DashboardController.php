<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Project;
use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('gaelpaquien.com — Admin')
            ->setLocales(['fr']);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::section('Contenu');
        yield MenuItem::linkToCrud('Projets en vedette', 'fa fa-folder', Project::class);
        yield MenuItem::linkToCrud('Articles de blog', 'fa fa-file-lines', Article::class);
        yield MenuItem::linkToCrud('Avis', 'fa fa-star', Review::class);
        yield MenuItem::section();
        yield MenuItem::linkToUrl('Voir le site', 'fa fa-external-link', '/')->setLinkTarget('_blank');
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out');
    }
}
