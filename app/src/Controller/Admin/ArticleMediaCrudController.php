<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\ArticleMedia;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleMediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArticleMedia::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('media', 'Fichier (chemin ou URL)');
        yield TextField::new('altText', 'Texte alternatif');
        yield BooleanField::new('isCover', 'Image de couverture');
    }
}
