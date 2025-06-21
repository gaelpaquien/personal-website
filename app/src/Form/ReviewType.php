<?php

declare(strict_types=1);

namespace App\Form;

use App\Service\RecaptchaService;
use App\Validator\Recaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ReviewType extends AbstractType
{
    public function __construct(
        private RecaptchaService $recaptchaService,
        private RequestStack $requestStack
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('authorFirstname', TextType::class, [
                'label' => 'post_review.form.first_name',
                'constraints' => [
                    new Assert\NotBlank(message: 'form.review.validation.first_name.not_blank'),
                    new Assert\Length(
                        min: 2,
                        max: 50,
                        minMessage: 'form.review.validation.first_name.min_length',
                        maxMessage: 'form.review.validation.first_name.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'post_review.form.first_name',
                ],
            ])
            ->add('authorLastname', TextType::class, [
                'label' => 'post_review.form.last_name',
                'constraints' => [
                    new Assert\NotBlank(message: 'form.review.validation.last_name.not_blank'),
                    new Assert\Length(
                        min: 2,
                        max: 50,
                        minMessage: 'form.review.validation.last_name.min_length',
                        maxMessage: 'form.review.validation.last_name.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'post_review.form.last_name',
                ],
            ])
            ->add('authorCompany', TextType::class, [
                'label' => 'post_review.form.company',
                'required' => false,
                'constraints' => [
                    new Assert\Length(
                        max: 100,
                        maxMessage: 'form.review.validation.company.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'post_review.form.company',
                ],
            ])
            ->add('authorJob', TextType::class, [
                'label' => 'post_review.form.role',
                'required' => false,
                'constraints' => [
                    new Assert\Length(
                        max: 100,
                        maxMessage: 'form.review.validation.role.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'post_review.form.role',
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'post_review.form.message',
                'constraints' => [
                    new Assert\NotBlank(message: 'form.review.validation.message.not_blank'),
                    new Assert\Length(
                        min: 20,
                        max: 1000,
                        minMessage: 'form.review.validation.message.min_length',
                        maxMessage: 'form.review.validation.message.max_length'
                    ),
                ],
                'attr' => [
                    'placeholder' => 'post_review.form.message',
                    'rows' => 5,
                ],
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
            'csrf_token_id' => 'review_form',
        ]);
    }
}