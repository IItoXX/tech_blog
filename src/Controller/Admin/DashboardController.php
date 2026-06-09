<?php

namespace App\Controller\Admin;

use App\Controller\Admin\CategoryCrudController;
use App\Controller\Admin\PostCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tech Blog');
    }

    public function configureMenuItems(): iterable {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkTo(CategoryCrudController::class, 'Category', 'fas fa-list');
        yield MenuItem::linkTo(PostCrudController::class, 'Post', 'fas fa-file');
    }
}
