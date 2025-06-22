<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Recaptcha extends Constraint
{
    public string $message = 'form.captcha_invalid';
}