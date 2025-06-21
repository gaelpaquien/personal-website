<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\RateLimiter\RateLimiterFactory;

trait FormHandlerTrait
{
    protected function handleForm(
        Request $request,
        FormInterface $form,
        callable $onSuccess,
        string $locale,
        string $successKey,
        string $errorKey,
        ?RateLimiterFactory $rateLimiterFactory = null,
        string $rateLimiterKey = 'default'
    ): ?JsonResponse {
        if (!$request->isXmlHttpRequest() || !$form->isSubmitted()) {
            return null;
        }

        if ($form->isValid()) {
            if ($rateLimiterFactory) {
                $limiter = $rateLimiterFactory->create($this->getRateLimiterIdentifier($request, $rateLimiterKey));
                $status = $limiter->consume();

                if (!$status->isAccepted()) {
                    $retryAfter = $status->getRetryAfter() ? $status->getRetryAfter()->getTimestamp() : time() + 300;
                    $request->getSession()->set("rate_limit_{$rateLimiterKey}", $retryAfter);

                    return $this->json([
                        'success' => false,
                        'message' => $this->translator->trans('form.rate_limit_exceeded', [], null, $locale),
                        'rate_limited' => true
                    ]);
                }
            }

            try {
                $result = $onSuccess($form->getData());

                return $this->json([
                    'success' => true,
                    'message' => $this->translator->trans($successKey, [], null, $locale),
                    'data' => $result['data'] ?? null
                ]);
            } catch (Exception $e) {
                $this->getLogger()?->error('AJAX form processing failed', [
                    'form' => $form->getName(),
                    'error' => $e->getMessage()
                ]);

                return $this->json([
                    'success' => false,
                    'message' => $this->translator->trans($errorKey, [], null, $locale)
                ]);
            }
        }

        return $this->json([
            'success' => false,
            'errors' => $this->formatFormErrors($form)
        ]);
    }

    protected function checkRateLimit(
        Request $request,
        RateLimiterFactory $rateLimiterFactory,
        string $rateLimiterKey,
        string $locale
    ): ?JsonResponse {
        $limiter = $rateLimiterFactory->create($this->getRateLimiterIdentifier($request, $rateLimiterKey));
        $status = $limiter->consume();

        if (!$status->isAccepted()) {
            $retryAfter = $status->getRetryAfter() ? $status->getRetryAfter()->getTimestamp() : time() + 300;
            $request->getSession()->set("rate_limit_{$rateLimiterKey}", $retryAfter);

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => $this->translator->trans('form.rate_limit_exceeded', [], null, $locale),
                    'rate_limited' => true
                ]);
            }

            $this->addFlash('error', $this->translator->trans('form.rate_limit_exceeded', [], null, $locale));
        }

        return null;
    }

    protected function getRateLimiterStatus(Request $request, RateLimiterFactory $rateLimiterFactory, string $rateLimiterKey): array
    {
        $sessionKey = "rate_limit_{$rateLimiterKey}";
        $retryAfterTimestamp = $request->getSession()->get($sessionKey, 0);

        if ($retryAfterTimestamp > time()) {
            return [
                'is_limited' => true,
                'retry_after' => $retryAfterTimestamp - time()
            ];
        }

        if ($retryAfterTimestamp > 0) {
            $request->getSession()->remove($sessionKey);
        }

        return [
            'is_limited' => false,
            'retry_after' => 0
        ];
    }

    private function getRateLimiterIdentifier(Request $request, string $key): string
    {
        return $key . '_' . md5($request->getClientIp() . $request->headers->get('User-Agent', ''));
    }

    private function formatFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $field = $error->getOrigin()?->getName() ?? 'form';
            $errors[$field][] = $error->getMessage();
        }
        return $errors;
    }

    private function getLogger(): ?LoggerInterface
    {
        return property_exists($this, 'logger') ? $this->logger : null;
    }
}