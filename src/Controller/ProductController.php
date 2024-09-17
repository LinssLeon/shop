<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/produkte', name: 'product_index')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $productRepository = $entityManager->getRepository(Product::class);
        $categoryRepository = $entityManager->getRepository(Category::class);

        // Optional: Filterfunktion
        $category = $request->query->get('category');
        $queryBuilder = $productRepository->createQueryBuilder('p');

        if ($category) {
            $queryBuilder->where('p.category = :category')
                ->setParameter('category', $category);
        }

        $products = $queryBuilder->getQuery()->getResult();
        $categories = $categoryRepository->findAll();
        $selectedCategory = $category ? $categoryRepository->find($category) : null;

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
