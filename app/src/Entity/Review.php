<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\Table(name: 'reviews')]
class Review
{
    public const STATUS_PENDING = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_REJECTED = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $authorFirstname = null;

    #[ORM\Column(length: 255)]
    private ?string $authorLastname = null;

    #[ORM\Column(length: 255)]
    private ?string $authorJobFr = null;

    #[ORM\Column(length: 255)]
    private ?string $authorJobEn = null;

    #[ORM\Column(length: 255)]
    private ?string $authorCompany = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEn = null;

    #[ORM\Column(length: 255)]
    private ?string $source = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $order = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = self::STATUS_PENDING;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorFirstname(): ?string
    {
        return $this->authorFirstname;
    }

    public function setAuthorFirstname(string $authorFirstname): static
    {
        $this->authorFirstname = $authorFirstname;
        return $this;
    }

    public function getAuthorLastname(): ?string
    {
        return $this->authorLastname;
    }

    public function setAuthorLastname(string $authorLastname): static
    {
        $this->authorLastname = $authorLastname;
        return $this;
    }

    public function getAuthorJobFr(): ?string
    {
        return $this->authorJobFr;
    }

    public function setAuthorJobFr(string $authorJobFr): static
    {
        $this->authorJobFr = $authorJobFr;
        return $this;
    }

    public function getAuthorJobEn(): ?string
    {
        return $this->authorJobEn;
    }

    public function setAuthorJobEn(string $authorJobEn): static
    {
        $this->authorJobEn = $authorJobEn;
        return $this;
    }

    public function getAuthorCompany(): ?string
    {
        return $this->authorCompany;
    }

    public function setAuthorCompany(string $authorCompany): static
    {
        $this->authorCompany = $authorCompany;
        return $this;
    }

    public function getContentFr(): ?string
    {
        return $this->contentFr;
    }

    public function setContentFr(string $contentFr): static
    {
        $this->contentFr = $contentFr;
        return $this;
    }

    public function getContentEn(): ?string
    {
        return $this->contentEn;
    }

    public function setContentEn(string $contentEn): static
    {
        $this->contentEn = $contentEn;
        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;
        return $this;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(int $order): static
    {
        $this->order = $order;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getAuthorFullName(): string
    {
        return $this->authorFirstname . ' ' . $this->authorLastname;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function approve(): static
    {
        $this->status = self::STATUS_APPROVED;
        return $this;
    }

    public function reject(): static
    {
        $this->status = self::STATUS_REJECTED;
        return $this;
    }
}