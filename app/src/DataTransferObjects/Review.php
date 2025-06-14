<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

class Review implements DTO
{
    public function __construct(
        public string $authorFirstName,
        public string $authorLastName,
        public ?string $authorJobTitle,
        public ?string $authorCompany,
        public string $content,
        public string $source,
        public string $createdAt,
    ) {}
}