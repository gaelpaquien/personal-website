<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use App\Service\MailService;
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

        if ($rateLimiterFactory) {
            $rateLimitResponse = $this->checkRateLimit($request, $rateLimiterFactory, $rateLimiterKey, $locale);
            if ($rateLimitResponse) {
                return $rateLimitResponse;
            }
        }

        if ($this->isBot($request)) {
            $this->handleBotDetection($request, $form, $locale);

            return $this->json([
                'success' => true,
                'message' => $this->translator->trans($successKey, [], null, $locale)
            ]);
        }

        if ($form->isValid()) {
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

    protected function isBot(Request $request): bool
    {
        if ($this->isHoneypotFilled($request)) {
            return true;
        }

        if ($this->isSubmittedTooFast($request)) {
            return true;
        }

        if ($this->isJavaScriptDisabled($request)) {
            return true;
        }

        return false;
    }

    private function handleBotDetection(Request $request, FormInterface $form, string $locale): void
    {
        $botData = $this->prepareBotData($request, $form);

        $this->getLogger()?->warning('Bot detected on form submission', $botData);

        if (property_exists($this, 'mailService') && $this->mailService instanceof MailService) {
            try {
                $this->mailService->sendBotDetectionEmail($botData, $locale);
            } catch (\Exception $e) {
                $this->getLogger()?->error('Failed to send bot detection email', [
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    private function prepareBotData(Request $request, FormInterface $form): array
    {
        $websiteValue = $this->getHoneypotValue($request);

        $formData = [];
        foreach ($form->all() as $child) {
            if (!$child->getConfig()->getOption('mapped', true)) {
                continue;
            }
            $formData[$child->getName()] = $child->getData();
        }

        return [
            'ip' => $this->getRealClientIp($request),
            'user_agent' => $request->headers->get('User-Agent'),
            'form' => $form->getName(),
            'honeypot_filled' => !empty($websiteValue),
            'too_fast' => $this->isSubmittedTooFast($request),
            'no_js' => $this->isJavaScriptDisabled($request),
            'form_data' => $formData,
            'timestamp' => date('d-m-Y H:i:s')
        ];
    }

    private function isHoneypotFilled(Request $request): bool
    {
        $allData = $request->request->all();

        foreach ($allData as $value) {
            if (is_array($value) && !empty($value['website'])) {
                return true;
            }
        }

        return !empty($request->request->get('website'));
    }

    private function getHoneypotValue(Request $request): string
    {
        $allData = $request->request->all();

        foreach ($allData as $value) {
            if (is_array($value) && isset($value['website'])) {
                return $value['website'];
            }
        }

        return $request->request->get('website', '');
    }

    private function isSubmittedTooFast(Request $request): bool
    {
        $formLoadedAt = $request->request->get('form_loaded_at');
        return $formLoadedAt && (time() - (int)$formLoadedAt) < 3;
    }

    private function isJavaScriptDisabled(Request $request): bool
    {
        return empty($request->request->get('js_enabled'));
    }

    private function getRealClientIp(Request $request): string
    {
        $ipHeaders = [
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED'
        ];

        foreach ($ipHeaders as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                $ip = trim($ips[0]);

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $request->getClientIp() ?? 'unknown';
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

            return $this->json([
                'success' => false,
                'message' => $this->translator->trans('form.rate_limit_exceeded', [], null, $locale),
                'rate_limited' => true
            ]);
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
        return $key . '_' . md5($this->getRealClientIp($request) . $request->headers->get('User-Agent', ''));
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