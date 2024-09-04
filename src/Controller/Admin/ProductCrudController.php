<?php

// src/Controller/Admin/ProductCrudController.php
namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    // Set the title of the page
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Manage Products') // Set title for the index page
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit Product') // Set title for the edit page
            ->setPageTitle(Crud::PAGE_NEW, 'Create New Product'); // Set title for the new product page
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            MoneyField::new('price')
                ->setCurrency('EUR')
                ->setStoredAsCents(false)
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

    // Add filters for better search functionality
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('name')) // Filter by product name
            ->add(NumericFilter::new('price')) // Filter by price
            ->add(EntityFilter::new('category')); // Filter by category
    }
}
