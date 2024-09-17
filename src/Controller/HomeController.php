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

        // Anzahl der Produkte in jeder Kategorie berechnen
        $categoryCounts = [];
        foreach ($categories as $category) {
            $categoryCounts[$category->getId()] = count($productRepository->findBy(['category' => $category]));
        }

        // Einkaufswagen-Logik: Anzahl der Artikel im Warenkorb holen
        $cartQuantity = $this->getCartQuantity($session);

        // Daten an das Template übergeben
        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
            'categoryCounts' => $categoryCounts, // Anzahl der Produkte in jeder Kategorie
            'cartQuantity' => $cartQuantity, // Anzahl der Artikel im Warenkorb
        ]);
    }
}
