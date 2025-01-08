<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Form;

use App\User\Application\DTO\UserRegistrationDTO;
use App\User\Application\Security\UserRegistrationFormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType implements UserRegistrationFormInterface
{

    private FormInterface  $form;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'error_bubbling' => true
            ])
            ->add('password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => "The password's fields must match.",
                'required' => true,
                // 'mapped' => false,
                // 'attr' => ['autocomplete' => 'new-password'],
                'first_options' => [
                    'label' => 'Password'
                ],
                'second_options' => [
                    'label' => "Repeat Password"
                ],
                'error_bubbling' => true
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'error_bubbling' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserRegistrationDTO::class,
            'error_bubbling' => true
        ]);
    }

    public function handleRequest($data): void
    {
        $this->form = $data;
    }

    public function isValid(): bool
    {
        return $this->form->isSubmitted() && $this->form->isValid();
    }

    public function getData(): UserRegistrationDTO
    {
        return new UserRegistrationDTO(
            $this->form->get('email')->getData(),
            $this->form->get('password')->getData()
        );
    }
}
