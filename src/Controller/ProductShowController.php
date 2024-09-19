<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductShowController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function show(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        $editReviewId = $request->query->get('editReviewId');
        $editReviewForm = null;

        if ($editReviewId) {
            $editReview = $entityManager->getRepository(Review::class)->find($editReviewId);
            if ($editReview && $editReview->getUser() === $this->getUser()) {
                $editReviewForm = $this->createForm(ReviewType::class, $editReview);
                $editReviewForm->handleRequest($request);

                if ($editReviewForm->isSubmitted() && $editReviewForm->isValid()) {
                    $entityManager->flush();
                    return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
                }
            }
        }

        if ($form->isSubmitted() && $form->isValid() && !$editReviewId) {
            if ($review->getRating() === null) {
                $this->addFlash('error', 'Bitte eine Bewertung auswählen.');
                return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
            }

            $review->setProduct($product);
            $review->setUser($this->getUser());
            $review->setCreatedAt(new \DateTime());
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }


        return $this->render('product/show.html.twig', [
            'product' => $product,
            'cartQuantity' => 0, // Beispielwert, anpassen nach Bedarf
            'reviews' => $product->getReviews(),
            'reviewForm' => $form->createView(),
            'editReviewForm' => $editReviewForm ? $editReviewForm->createView() : null,
            'editReviewId' => $editReviewId,
        ]);
    }

    #[Route('/review/delete/{id}', name: 'review_delete')]
    public function deleteReview(int $id, EntityManagerInterface $entityManager): Response
    {
        $review = $entityManager->getRepository(Review::class)->find($id);

        if (!$review || $review->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException('The review does not exist or you do not have permission to delete it.');
        }

        $entityManager->remove($review);
        $entityManager->flush();

        return $this->redirectToRoute('product_show', ['id' => $review->getProduct()->getId()]);
    }
}
