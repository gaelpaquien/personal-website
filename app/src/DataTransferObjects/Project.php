<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

class Project implements DTO
{
    public function __construct(
        public string $title,
        public string $description,
        public array $tags,
        public string $coverImage,
        public string $coverImageAltText,
        public string $relatedArticleSlug,
    ) {}
}