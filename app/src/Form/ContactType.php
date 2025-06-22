<?php

declare(strict_types=1);

namespace App\Form;

use App\Validator\Recaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'home.sections.contact.form.first_name',
                'constraints' => [
                    new Assert\NotBlank(message: 'form.contact.validation.first_name.not_blank'),
                    new Assert\Length(
                        min: 2,
                        max: 50,
                        minMessage: 'form.contact.validation.first_name.min_length',
                        maxMessage: 'form.contact.validation.first_name.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'home.sections.contact.form.first_name',
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'home.sections.contact.form.last_name',
                'constraints' => [
                    new Assert\NotBlank(message: 'form.contact.validation.last_name.not_blank'),
                    new Assert\Length(
                        min: 2,
                        max: 50,
                        minMessage: 'form.contact.validation.last_name.min_length',
                        maxMessage: 'form.contact.validation.last_name.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'home.sections.contact.form.last_name',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'home.sections.contact.form.email',
                'constraints' => [
                    new Assert\NotBlank(message: 'form.contact.validation.email.not_blank'),
                    new Assert\Email(message: 'form.contact.validation.email.invalid'),
                    new Assert\Length(
                        max: 255,
                        maxMessage: 'form.contact.validation.email.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'home.sections.contact.form.email',
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'home.sections.contact.form.phone',
                'required' => false,
                'constraints' => [
                    new Assert\Length(
                        min: 8,
                        max: 20,
                        minMessage: 'form.contact.validation.phone.min_length',
                        maxMessage: 'form.contact.validation.phone.max_length'
                    ),
                    new Assert\Regex(
                        pattern: '/^[\+]?[0-9\s\-\(\)\.]+$/',
                        message: 'form.contact.validation.phone.invalid'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'home.sections.contact.form.phone',
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'home.sections.contact.form.subject',
                'constraints' => [
                    new Assert\NotBlank(message: 'form.contact.validation.subject.not_blank'),
                    new Assert\Length(
                        min: 5,
                        max: 100,
                        minMessage: 'form.contact.validation.subject.min_length',
                        maxMessage: 'form.contact.validation.subject.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'home.sections.contact.form.subject',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'home.sections.contact.form.message',
                'constraints' => [
                    new Assert\NotBlank(message: 'form.contact.validation.message.not_blank'),
                    new Assert\Length(
                        min: 10,
                        max: 2000,
                        minMessage: 'form.contact.validation.message.min_length',
                        maxMessage: 'form.contact.validation.message.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'home.sections.contact.form.message',
                    'rows' => 5,
                ],
            ])
            ->add('attachment', FileType::class, [
                'label' => 'home.sections.contact.form.files',
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new Assert\All([
                        new Assert\File(
                            maxSize: '8M',
                            mimeTypes: [
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'image/jpeg',
                                'image/png',
                            ],
                            maxSizeMessage: 'form.contact.validation.attachment.max_size',
                            mimeTypesMessage: 'form.contact.validation.attachment.mime_types'
                        ),
                    ]),
                    new Assert\Count(
                        max: 3,
                        maxMessage: 'form.contact.validation.attachment.max_count'
                    ),
                ],
                'attr' => [
                    'accept' => '.pdf,.doc,.docx,.xlsx,.jpg,.jpeg,.png',
                ],
            ])
            ->add('receiveCopy', CheckboxType::class, [
                'label' => 'home.sections.contact.form.receive_copy',
                'required' => false,
            ])
            ->add('recaptcha', HiddenType::class, [
                'mapped' => false,
                'data' => '',
                'constraints' => [
                    new Recaptcha()
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'contact_form',
        ]);
    }
}