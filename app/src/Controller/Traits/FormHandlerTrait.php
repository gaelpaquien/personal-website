<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait FormHandlerTrait
{
    protected function handleForm(
        Request $request,
        FormInterface $form,
        callable $onSuccess,
        string $locale,
        string $successKey,
        string $errorKey
    ): ?JsonResponse {
        if (!$request->isXmlHttpRequest() || !$form->isSubmitted()) {
            return null;
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