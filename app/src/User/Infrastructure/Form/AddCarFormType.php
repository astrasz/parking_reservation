<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Form;

use App\User\Application\DTO\AddCarDTO;
use App\User\Application\Form\AddCarFormInterface;
use App\User\Domain\Entity\CarBrand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCarFormType extends AbstractType implements AddCarFormInterface
{

    private FormInterface $form;


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', EnumType::class, [
                'class' => CarBrand::class,
                'translation_domain' => false
            ])
            ->add('registrationNo', TextType::class);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddCarDTO::class,
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

    public function getData(): AddCarDTO
    {
        return new AddCarDTO(
            $this->form->get('brand')->getData(),
            $this->form->get('registrationNo')->getData()
        );
    }
}
