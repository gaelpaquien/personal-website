<?php

declare(strict_types=1);

namespace App\Exception;

class RedirectArticleException extends \Exception
{
    public function __construct(public readonly string $slug)
    {
        parent::__construct();
    }
}