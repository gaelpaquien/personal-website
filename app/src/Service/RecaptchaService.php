<?php

declare(strict_types=1);

namespace App\Service;

use ReCaptcha\ReCaptcha;

class RecaptchaService
{
    /*private ReCaptcha $recaptcha;

    public function __construct(
        string $secretKey,
    ) {
        $this->recaptcha = new ReCaptcha($secretKey);
    }

    public function verify(string $response, string $remoteIp = null): bool
    {
        if (!$response) {
            return false;
        }

        $result = $this->recaptcha->verify($response, $remoteIp);

        return $result->isSuccess();
    }*/
}