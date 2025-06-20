<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class ReviewService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
    ) {}

    public function createReview(array $formData, string $locale): bool
    {
        try {
            $review = new Review();
            $review
                ->setAuthorFirstname($formData['authorFirstname'])
                ->setAuthorLastname($formData['authorLastname'])
                ->setAuthorJobFr($formData['authorJob'] ?? '')
                ->setAuthorJobEn($formData['authorJob'] ?? '')
                ->setAuthorCompany($formData['authorCompany'] ?? '')
                ->setContentFr($formData['content'])
                ->setContentEn($formData['content'])
                ->setSource($this->translator->trans('info.site.name', [], null, $locale))
                ->setStatus(Review::STATUS_PENDING);

            $this->entityManager->persist($review);
            $this->entityManager->flush();

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }
}