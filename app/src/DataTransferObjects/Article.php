<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

class Article implements DTO
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $shortDescription,
        public string $content,
        public array $tags,
        public ?array $resourceLinks,
        public string $updatedAt,
        public string $coverImage,
        public string $coverImageAltText,
    ) {}
}