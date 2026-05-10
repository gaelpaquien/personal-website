<?php

namespace App\Entity;

use App\Repository\ArticleMediaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleMediaRepository::class)]
#[ORM\Table(name: 'article_medias')]
class ArticleMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'medias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $article = null;

    #[ORM\Column(length: 255)]
    private ?string $media = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $altText = null;

    #[ORM\Column]
    private ?bool $isCover = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;
        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(string $media): static
    {
        $this->media = $media;
        return $this;
    }

    public function getAltText(): ?string
    {
        return $this->altText;
    }

    public function setAltText(?string $altText): static
    {
        $this->altText = $altText;
        return $this;
    }

    public function isCover(): ?bool
    {
        return $this->isCover;
    }

    public function setIsCover(bool $isCover): static
    {
        $this->isCover = $isCover;
        return $this;
    }
}
