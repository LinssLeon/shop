<?php
// src/EventListener/ProductListener.php
namespace App\EventListener;

use App\Entity\Product;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ProductListener
{
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Product) {
            return;
        }

        $this->sanitizeDescription($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Product) {
            return;
        }

        $this->sanitizeDescription($entity);
    }

    private function sanitizeDescription(Product $product): void
    {
        $product->setDescription(strip_tags($product->getDescription()));
    }
}
