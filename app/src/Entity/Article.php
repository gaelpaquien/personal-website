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
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): static
    {
        $this->tags = $tags;
        return $this;
    }

    public function addTag(string $tag): static
    {
        if (!in_array($tag, $this->tags, true)) {
            $this->tags[] = $tag;
        }
        return $this;
    }

    public function removeTag(string $tag): static
    {
        $this->tags = array_values(array_filter($this->tags, fn($t) => $t !== $tag));
        return $this;
    }

    public function getResourceLinks(): ?array
    {
        return $this->resourceLinks;
    }

    public function setResourceLinks(?array $resourceLinks): static
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

    public function getCoverMedia(): ?ArticleMedia
    {
        foreach ($this->medias as $media) {
            if ($media->isCover()) {
                return $media;
            }
        }
        return null;
    }

    public function __toString(): string
    {
        return $this->title ?? '';
    }
}
