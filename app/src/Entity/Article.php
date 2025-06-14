<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'articles')]
#[ORM\HasLifecycleCallbacks]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titleFr = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEn = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slugFr = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slugEn = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $shortDescriptionFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $shortDescriptionEn = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentFr = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentEn = null;

    #[ORM\Column(type: Types::JSON)]
    private array $tags = [];

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $resourceLinks = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: ArticleMedia::class, mappedBy: 'article', orphanRemoval: true)]
    private Collection $medias;

    #[ORM\OneToOne(targetEntity: Project::class, mappedBy: 'article')]
    private ?Project $project = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->medias = new ArrayCollection();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleFr(): ?string
    {
        return $this->titleFr;
    }

    public function setTitleFr(string $titleFr): static
    {
        $this->titleFr = $titleFr;
        return $this;
    }

    public function getTitleEn(): ?string
    {
        return $this->titleEn;
    }

    public function setTitleEn(string $titleEn): static
    {
        $this->titleEn = $titleEn;
        return $this;
    }

    public function getSlugFr(): ?string
    {
        return $this->slugFr;
    }

    public function setSlugFr(string $slugFr): static
    {
        $this->slugFr = $slugFr;
        return $this;
    }

    public function getSlugEn(): ?string
    {
        return $this->slugEn;
    }

    public function setSlugEn(string $slugEn): static
    {
        $this->slugEn = $slugEn;
        return $this;
    }

    public function getShortDescriptionFr(): ?string
    {
        return $this->shortDescriptionFr;
    }

    public function setShortDescriptionFr(string $shortDescriptionFr): static
    {
        $this->shortDescriptionFr = $shortDescriptionFr;
        return $this;
    }

    public function getShortDescriptionEn(): ?string
    {
        return $this->shortDescriptionEn;
    }

    public function setShortDescriptionEn(string $shortDescriptionEn): static
    {
        $this->shortDescriptionEn = $shortDescriptionEn;
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

    public function getTags(?string $locale = null): array
    {
        if ($locale) {
            return $this->tags[$locale] ?? [];
        }
        return $this->tags;
    }

    public function setTags(array $tags): static
    {
        $this->tags = $tags;
        return $this;
    }

    public function addTag(string $tag, string $locale): static
    {
        if (!isset($this->tags[$locale])) {
            $this->tags[$locale] = [];
        }
        if (!in_array($tag, $this->tags[$locale])) {
            $this->tags[$locale][] = $tag;
        }
        return $this;
    }

    public function removeTag(string $tag, string $locale): static
    {
        if (isset($this->tags[$locale])) {
            $this->tags[$locale] = array_values(array_filter($this->tags[$locale], fn($t) => $t !== $tag));
        }
        return $this;
    }

    public function getResourceLinks(?string $locale = null): ?array
    {
        if ($this->resourceLinks === null) {
            return null;
        }

        if ($locale) {
            return $this->resourceLinks[$locale] ?? [];
        }
        return $this->resourceLinks;
    }

    public function setResourceLinks(array $resourceLinks): static
    {
        $this->resourceLinks = $resourceLinks;
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection<int, ArticleMedia>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(ArticleMedia $media): static
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->setArticle($this);
        }
        return $this;
    }

    public function removeMedia(ArticleMedia $media): static
    {
        if ($this->medias->removeElement($media)) {
            if ($media->getArticle() === $this) {
                $media->setArticle(null);
            }
        }
        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        if ($project === null && $this->project !== null) {
            $this->project->setArticle(null);
        }

        if ($project !== null && $project->getArticle() !== $this) {
            $project->setArticle($this);
        }

        $this->project = $project;
        return $this;
    }

    public function getTitle(string $locale = 'fr'): ?string
    {
        return $locale === 'en' ? $this->titleEn : $this->titleFr;
    }

    public function getSlug(string $locale = 'fr'): ?string
    {
        return $locale === 'en' ? $this->slugEn : $this->slugFr;
    }

    public function getContent(string $locale = 'fr'): ?string
    {
        return $locale === 'en' ? $this->contentEn : $this->contentFr;
    }

    public function getShortDescription(string $locale = 'fr'): ?string
    {
        return $locale === 'en' ? $this->shortDescriptionEn : $this->shortDescriptionFr;
    }

    public function getCoverMedia(): ?ArticleMedia
    {
        foreach ($this->medias as $media) {
            if ($media->isCover()) {
                return $media;
            }
        }
        return null;
    }
}