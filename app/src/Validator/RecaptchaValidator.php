<?php

namespace App\Validator;

use App\Service\RecaptchaService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RecaptchaValidator extends ConstraintValidator
{
    public function __construct(
        private RecaptchaService $recaptchaService,
        private RequestStack $requestStack
    ) {}

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Recaptcha) {
            throw new \InvalidArgumentException('Expected instance of ' . Recaptcha::class);
        }

        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return;
        }

        $recaptchaResponse = $request->request->get('g-recaptcha-response');

        if (!$recaptchaResponse || !$this->recaptchaService->verify($recaptchaResponse, $request->getClientIp())) {
            $this->context->buildViolation($constraint->message)
                ->setTranslationDomain('validators')
                ->addViolation();
        }
    }
}