<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController {
    #[Route('/categories', name: 'app_categories_list')]
    public function list(CategoryRepository $categoryRepository): Response {
        $categories = $categoryRepository->findAll();
        return $this->render('category/list.html.twig', ['categories' => $categories]);
    }
    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(Category $categorie): Response {
        return $this->render('category/show.html.twig', ['categorie' => $categorie]);
    }
}