<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Avis')
            ->setEntityLabelInPlural('Avis')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setSearchFields(['authorFirstname', 'authorLastname', 'authorCompany', 'content']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('authorFirstname', 'Prénom');
        yield TextField::new('authorLastname', 'Nom');
        yield TextField::new('authorJob', 'Poste / Rôle');
        yield TextField::new('authorCompany', 'Société / Entité');
        yield TextareaField::new('content', 'Contenu')->hideOnIndex();
        yield TextField::new('source', 'Source');
        yield ChoiceField::new('status', 'Statut')
            ->setChoices([
                'En attente' => Review::STATUS_PENDING,
                'Approuvé' => Review::STATUS_APPROVED,
                'Rejeté' => Review::STATUS_REJECTED,
            ])
            ->renderAsBadges([
                Review::STATUS_PENDING => 'warning',
                Review::STATUS_APPROVED => 'success',
                Review::STATUS_REJECTED => 'danger',
            ]);
        yield IntegerField::new('sortOrder', 'Ordre d\'affichage')->hideOnIndex();
        yield DateTimeField::new('createdAt', 'Reçu le')->hideOnForm();
    }
}
