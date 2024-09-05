<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        // Hole ausgewählte Kategorien, sollte ein Array sein
        $selectedCategories = $request->query->all('categories');

        if (!is_array($selectedCategories)) {
            $selectedCategories = [];
        }

        // Filtere leere Werte aus
        $selectedCategories = array_filter($selectedCategories, fn($value) => !empty($value));

        // Produkte nach Kategorien suchen
        $products = $productRepository->findByCategories($selectedCategories);

        // Alle Kategorien für den Filter holen
        $categories = $categoryRepository->findAll();

        // Daten an das Template übergeben
        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
        ]);
    }
}
