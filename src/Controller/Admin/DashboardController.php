<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use App\Entity\Product;
use App\Entity\Category;

class DashboardController extends AbstractDashboardController
{
    #[Route('', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Übersicht')
            ->setFaviconPath('images/favicon.ico'); // Set the favicon path here
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Übersicht', 'fa fa-home');
        yield MenuItem::linkToCrud('Produkte', 'fas fa-box', Product::class);
        yield MenuItem::linkToCrud('Kategorien', 'fas fa-tags', Category::class);
    }
}
