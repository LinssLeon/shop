<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends BaseController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository, SessionInterface $session): Response
    {
        // Holen der Featured-Produkte
        $featuredProducts = $productRepository->findBy(['isFeatured' => true]);

        // Hole die Produkte nach Kategorie
        $selectedCategories = $request->query->all('categories');
        $selectedCategories = array_filter((array)$selectedCategories, fn($value) => !empty($value));
        $products = $productRepository->findByCategories($selectedCategories);

        // Hole alle Kategorien für den Filter
        $categories = $categoryRepository->findAll();

        $cartQuantity = $this->getCartQuantity($session);

        return $this->render('home/index.html.twig', [
            'featuredProducts' => $featuredProducts,
            'products' => $products,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
            'cartQuantity' => $cartQuantity,
        ]);
    }
}
