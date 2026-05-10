<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\ArticleMedia;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Articles')
            ->setDefaultSort(['updatedAt' => 'DESC'])
            ->setSearchFields(['title', 'slug', 'shortDescription']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Contenu');
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'Titre');
        yield SlugField::new('slug')->setTargetFieldName('title')->setUnlockConfirmationMessage('Es-tu sûr de modifier ce slug ? Cela peut affecter les liens existants.');
        yield TextareaField::new('shortDescription', 'Description courte');
        yield TextEditorField::new('content', 'Contenu')->hideOnIndex();
        yield ArrayField::new('tags', 'Tags');

        yield FormField::addTab('Médias');
        yield CollectionField::new('medias', 'Médias')
            ->useEntryCrudForm(ArticleMediaCrudController::class)
            ->setEntryIsComplex()
            ->hideOnIndex();

        yield FormField::addTab('Projet associé');
        yield AssociationField::new('project', 'Projet en vedette')->hideOnIndex();

        yield FormField::addTab('Dates');
        yield DateTimeField::new('createdAt', 'Créé le')->hideOnForm();
        yield DateTimeField::new('updatedAt', 'Mis à jour le')->hideOnForm();
    }
}
