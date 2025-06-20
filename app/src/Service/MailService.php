<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class MailService
{
    public function __construct(
        private MailerInterface $mailer,
        private TranslatorInterface $translator,
        private string $contactEmail
    ) {}

    public function sendContactEmail(array $formData, string $locale): bool
    {
        try {
            $subject = $this->translator->trans('info.site.name', [], null, $locale) . ' - ' .
                $this->translator->trans('form.contact.email.title') .
                ' - ' . $formData['subject'];

            $email = (new Email())
                ->from($this->contactEmail)
                ->replyTo($formData['email'])
                ->to($this->contactEmail)
                ->subject($subject)
                ->html($this->buildContactEmailContent($formData, $locale));

            if (!empty($formData['attachment'])) {
                foreach ($formData['attachment'] as $file) {
                    if ($file instanceof UploadedFile) {
                        $email->attachFromPath(
                            $file->getPathname(),
                            $file->getClientOriginalName(),
                            $file->getClientMimeType() ?: 'application/octet-stream'
                        );
                    }
                }
            }

            $this->mailer->send($email);

            if ($formData['receiveCopy'] ?? false) {
                $this->sendContactCopyToSender($formData, $locale);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function sendReviewNotificationEmail(array $formData, string $locale): bool
    {
        try {
            $subject = $this->translator->trans('info.site.name', [], null, $locale) . ' - ' .
                $this->translator->trans('form.review.email.title', [], null, $locale);

            $email = (new Email())
                ->from($this->contactEmail)
                ->to($this->contactEmail)
                ->subject($subject)
                ->html($this->buildReviewEmailContent($formData, $locale));

            $this->mailer->send($email);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function sendContactCopyToSender(array $formData, string $locale): void
    {
        $subject = $this->translator->trans('info.site.name', [], null, $locale) . ' - ' .
            $this->translator->trans('form.contact.email.copy_subject', [], null, $locale) .
            ' - ' . $formData['subject'];

        $copyEmail = (new Email())
            ->from($this->contactEmail)
            ->to($formData['email'])
            ->subject($subject)
            ->html($this->buildContactCopyEmailContent($formData, $locale));

        $this->mailer->send($copyEmail);
    }

    private function buildContactEmailContent(array $formData, string $locale): string
    {
        $attachmentCount = !empty($formData['attachment']) ? count($formData['attachment']) : 0;

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
            '<h2>%s</h2>
            <p>%s</p>
            <div>%s</div>
            <hr>',
            $this->translator->trans('form.contact.email.copy_title', [], null, $locale) . ' ' . $this->translator->trans('info.site.name', [], null, $locale),
            $this->translator->trans('form.contact.email.copy_intro', [], null, $locale) . ' ' . $this->translator->trans('info.site.name', [], null, $locale),
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
            <hr>
            <p><strong>ID:</strong> %s</p>
            <p><strong>Date:</strong> %s</p>',
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
            $formData['reviewId'] ?? 'N/A',
            $formData['createdAt'] ?? 'N/A'
        );
    }
}