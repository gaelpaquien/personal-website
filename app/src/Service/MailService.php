<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class MailService
{
    public function __construct(
        private MailerInterface $mailer,
        private TranslatorInterface $translator,
        private LoggerInterface $logger,
        private string $contactEmail
    ) {}

    public function sendContactEmail(array $formData, string $locale): bool
    {
        try {
            $email = (new Email())
                ->from($this->contactEmail)
                ->replyTo($formData['email'])
                ->to($this->contactEmail)
                ->subject($this->buildContactSubject($formData, $locale))
                ->html($this->buildContactEmailContent($formData, $locale));

            $this->attachFiles($email, $formData['attachment'] ?? []);
            $this->mailer->send($email);

            if ($formData['receiveCopy'] ?? false) {
                $this->sendContactCopyToSender($formData, $locale);
            }

            return true;

        } catch (TransportExceptionInterface $e) {
            $this->logger->error('Transport error sending contact email', [
                'recipient' => $formData['email'],
                'error' => $e->getMessage()
            ]);
            return false;
        } catch (Exception $e) {
            $this->logger->error('Unexpected error sending contact email', [
                'recipient' => $formData['email'],
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function sendReviewNotificationEmail(array $formData, string $locale): void
    {
        try {
            $email = (new Email())
                ->from($this->contactEmail)
                ->to($this->contactEmail)
                ->subject($this->buildReviewSubject($locale))
                ->html($this->buildReviewEmailContent($formData, $locale));

            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('Transport error sending review notification', [
                'reviewId' => $formData['reviewId'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            throw $e;
        } catch (Exception $e) {
            $this->logger->error('Unexpected error sending review notification', [
                'reviewId' => $formData['reviewId'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    private function sendContactCopyToSender(array $formData, string $locale): void
    {
        try {
            $copyEmail = (new Email())
                ->from($this->contactEmail)
                ->to($formData['email'])
                ->subject($this->buildContactCopySubject($formData, $locale))
                ->html($this->buildContactCopyEmailContent($formData, $locale));

            $this->mailer->send($copyEmail);
        } catch (TransportExceptionInterface $e) {
            $this->logger->warning('Transport error sending copy to sender', [
                'recipient' => $formData['email'],
                'error' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            $this->logger->warning('Failed to send copy to sender', [
                'recipient' => $formData['email'],
                'error' => $e->getMessage()
            ]);
        }
    }

    private function attachFiles(Email $email, array $files): void
    {
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                try {
                    $email->attachFromPath(
                        $file->getPathname(),
                        $file->getClientOriginalName(),
                        $file->getClientMimeType() ?: 'application/octet-stream'
                    );
                } catch (Exception $e) {
                    $this->logger->warning('Failed to attach file', [
                        'filename' => $file->getClientOriginalName(),
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
    }

    private function buildContactSubject(array $formData, string $locale): string
    {
        return sprintf('%s - %s - %s',
            $this->translator->trans('info.site.name', [], null, $locale),
            $this->translator->trans('form.contact.email.title', [], null, $locale),
            $formData['subject']
        );
    }

    private function buildContactCopySubject(array $formData, string $locale): string
    {
        return sprintf('%s - %s - %s',
            $this->translator->trans('info.site.name', [], null, $locale),
            $this->translator->trans('form.contact.email.copy_subject', [], null, $locale),
            $formData['subject']
        );
    }

    private function buildReviewSubject(string $locale): string
    {
        return sprintf('%s - %s',
            $this->translator->trans('info.site.name', [], null, $locale),
            $this->translator->trans('form.review.email.title', [], null, $locale)
        );
    }

    private function buildContactEmailContent(array $formData, string $locale): string
    {
        $attachmentCount = count($formData['attachment'] ?? []);

        return sprintf(
            '<h2>%s</h2>
            <p><strong>%s:</strong> %s</p>
            <p><strong>%s:</strong> %d</p>
            <p><strong>%s:</strong> %s %s</p>
            <p><strong>%s:</strong> %s</p>
            <p><strong>%s:</strong> %s</p>
            <p><strong>%s:</strong> %s</p>
            <div><strong>%s:</strong><br>%s</div>',
            $this->translator->trans('form.contact.email.title', [], null, $locale),
            $this->translator->trans('form.contact.email.language', [], null, $locale),
            htmlspecialchars($locale),
            $this->translator->trans('form.contact.email.attachment_count', [], null, $locale),
            $attachmentCount,
            $this->translator->trans('form.contact.email.identity', [], null, $locale),
            htmlspecialchars($formData['firstName']),
            htmlspecialchars($formData['lastName']),
            $this->translator->trans('form.contact.email.email', [], null, $locale),
            htmlspecialchars($formData['email']),
            $this->translator->trans('form.contact.email.phone', [], null, $locale),
            htmlspecialchars($formData['phone'] ?? $this->translator->trans('form.contact.email.phone_not_specified', [], null, $locale)),
            $this->translator->trans('form.contact.email.subject', [], null, $locale),
            htmlspecialchars($formData['subject']),
            $this->translator->trans('form.contact.email.message', [], null, $locale),
            nl2br(htmlspecialchars($formData['message']))
        );
    }

    private function buildContactCopyEmailContent(array $formData, string $locale): string
    {
        return sprintf(
            '<h2>%s %s</h2>
            <p>%s %s</p>
            <hr>
            <div>%s</div>',
            $this->translator->trans('form.contact.email.copy_title', [], null, $locale),
            $this->translator->trans('info.site.name', [], null, $locale),
            $this->translator->trans('form.contact.email.copy_intro', [], null, $locale),
            $this->translator->trans('info.site.name', [], null, $locale),
            $this->buildContactEmailContent($formData, $locale)
        );
    }

    private function buildReviewEmailContent(array $formData, string $locale): string
    {
        return sprintf(
            '<h2>%s</h2>
            <p><strong>%s:</strong> %s</p>
            <p><strong>%s:</strong> %s %s</p>
            <p><strong>%s:</strong> %s</p>
            <p><strong>%s:</strong> %s</p>
            <div><strong>%s:</strong><br>%s</div>
            <br>
            <hr>
            <h2>%s</h2>
            <p><strong>%s:</strong> %s</p>
            <p><strong>%s:</strong> %s</p>',
            $this->translator->trans('form.review.email.title', [], null, $locale),
            $this->translator->trans('form.review.email.language', [], null, $locale),
            htmlspecialchars($locale),
            $this->translator->trans('form.review.email.identity', [], null, $locale),
            htmlspecialchars($formData['authorFirstname'] ?? ''),
            htmlspecialchars($formData['authorLastname'] ?? ''),
            $this->translator->trans('form.review.email.company', [], null, $locale),
            htmlspecialchars($formData['authorCompany'] ?? $this->translator->trans('form.review.email.company_not_specified', [], null, $locale)),
            $this->translator->trans('form.review.email.role', [], null, $locale),
            htmlspecialchars($formData['authorJob'] ?? $this->translator->trans('form.review.email.role_not_specified', [], null, $locale)),
            $this->translator->trans('form.review.email.content', [], null, $locale),
            nl2br(htmlspecialchars($formData['content'] ?? '')),
            $this->translator->trans('form.review.email.title2', [], null, $locale),
            $this->translator->trans('form.review.email.review_id', [], null, $locale),
            $formData['reviewId'] ?? 'N/A',
            $this->translator->trans('form.review.email.review_date', [], null, $locale),
            $formData['createdAt'] ?? 'N/A',
        );
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function sendBotDetectionEmail(array $botData, string $locale): void
    {
        try {
            $email = (new Email())
                ->from($this->contactEmail)
                ->to($this->contactEmail)
                ->subject($this->buildBotDetectionSubject($locale))
                ->html($this->buildBotDetectionEmailContent($botData, $locale));

            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('Transport error sending bot detection email', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        } catch (Exception $e) {
            $this->logger->error('Unexpected error sending bot detection email', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    private function buildBotDetectionSubject(string $locale): string
    {
        return sprintf('%s - %s',
            $this->translator->trans('info.site.name', [], null, $locale),
            'Bot détecté'
        );
    }

    private function buildBotDetectionEmailContent(array $botData, string $locale): string
    {
        $reasons = [];
        if ($botData['honeypot_filled']) $reasons[] = 'Honeypot rempli';
        if ($botData['too_fast']) $reasons[] = 'Soumission trop rapide';
        if ($botData['no_js']) $reasons[] = 'JavaScript désactivé';

        $reasonsText = !empty($reasons) ? implode(', ', $reasons) : 'Aucune raison spécifique détectée';

        return sprintf(
            '<h2>🤖 Bot détecté</h2>
            <p><strong>Formulaire:</strong> %s</p>
            <p><strong>IP:</strong> %s</p>
            <p><strong>User Agent:</strong> %s</p>
            <p><strong>Raisons:</strong> %s</p>
            <p><strong>Date:</strong> %s</p>
            <hr>
            <h3>Données soumises:</h3>
            <pre>%s</pre>',
            htmlspecialchars($botData['form']),
            htmlspecialchars($botData['ip']),
            htmlspecialchars($botData['user_agent']),
            htmlspecialchars($reasonsText),
            $botData['timestamp'],
            htmlspecialchars(json_encode($botData['form_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
        );
    }
}