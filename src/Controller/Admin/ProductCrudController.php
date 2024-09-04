<?php

// src/Controller/Admin/ProductCrudController.php
namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            MoneyField::new('price')
                ->setCurrency('EUR') // Stellen Sie sicher, dass die Währung richtig gesetzt ist
                ->setStoredAsCents(false) // Falls Sie keine Cents benötigen
                ->setHelp('Enter the price in EUR'),
            TextareaField::new('description'),
            AssociationField::new('category'),
            ImageField::new('image')
                ->setBasePath('/uploads/images/products')
                ->setUploadDir('public/uploads/images/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];
    }
}
