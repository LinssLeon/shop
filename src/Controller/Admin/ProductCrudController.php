<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
            MoneyField::new('price')->setCurrency('EUR'),
            TextareaField::new('description'),
            AssociationField::new('category'),
            ImageField::new('image')
                ->setBasePath('/uploads/images/products') // Pfad relativ zu 'public' Ordner
                ->setUploadDir('public/uploads/images/products') // Verzeichnis relativ zum Projektverzeichnis
                ->setUploadedFileNamePattern('[randomhash].[extension]') // Optional: Muster für Dateinamen
                ->setRequired(false),
        ];
    }
}
