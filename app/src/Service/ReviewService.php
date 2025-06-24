<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Review;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

readonly class ReviewService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private LoggerInterface $logger,
        private MailService $mailService
    ) {}

    /**
     * @throws Exception
     * @throws TransportExceptionInterface
     * @throws Throwable
     */
    public function createReviewWithNotification(array $formData, string $locale): array
    {
        return $this->entityManager->getConnection()->transactional(
            function() use ($formData, $locale) {
                try {
                    $review = $this->createReview($formData, $locale);
                    $this->entityManager->flush();

                    $emailData = $this->prepareEmailData($formData, $review);
                    $this->mailService->sendReviewNotificationEmail($emailData, $locale);

                    return [
                        'success' => true,
                        'data' => [
                            'reviewId' => $review->getId(),
                            'createdAt' => $review->getCreatedAt()?->format('Y-m-d H:i:s')
                        ]
                    ];

                } catch (UniqueConstraintViolationException $e) {
                    $this->logger->error('Duplicate review submission attempt', [
                        'author' => $formData['authorFirstname'] . ' ' . $formData['authorLastname']
                    ]);
                    throw new Exception('This review has already been submitted.', 0, $e);
                } catch (Exception $e) {
                    $this->logger->error('Review creation failed', [
                        'author' => $formData['authorFirstname'] . ' ' . $formData['authorLastname'],
                        'error' => $e->getMessage()
                    ]);
                    throw $e;
                }
            }
        );
    }

    private function createReview(array $formData, string $locale): Review
    {
        $review = new Review();
        $review
            ->setAuthorFirstname($formData['authorFirstname'])
            ->setAuthorLastname($formData['authorLastname'])
            ->setAuthorCompany($formData['authorCompany'] ?? '')
            ->setAuthorJobFr($formData['authorJob'] ?? '')
            ->setAuthorJobEn($formData['authorJob'] ?? '')
            ->setContentFr($formData['content'])
            ->setContentEn($formData['content'])
            ->setSource($this->translator->trans('info.site.name', [], null, $locale))
            ->setStatus(Review::STATUS_PENDING);

        $this->entityManager->persist($review);
        return $review;
    }

    private function prepareEmailData(array $formData, Review $review): array
    {
        return [...$formData,
            'reviewId' => $review->getId(),
            'createdAt' => $review->getCreatedAt()?->format('d-m-Y H:i:s')
        ];
    }
}