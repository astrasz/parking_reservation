<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Form;

use App\Reservation\Application\DTO\ReservePlaceDTO;
use App\Reservation\Application\Form\ReservePlaceFormInterface;
use App\User\Domain\Repository\CarRepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservePlaceFormType extends AbstractType implements ReservePlaceFormInterface
{
    private FormInterface $form;

    public function __construct(private readonly CarRepositoryInterface $carRepo, private readonly Security $security) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('placeNo', NumberType::class)
            ->add('carId', ChoiceType::class, [
                'choices' => $this->getCarsChoices(),
                'choice_label' => function ($key, $value) {
                    return $value ? $value : null;
                },
                'choice_value' => function ($key) {
                    return $key ? $key : null;
                }
            ])
            ->add('start', DateTimeType::class, [
                'time_label' => 'Starts On',
                // 'required' => false
            ])
            ->add('end', DateTimeType::class, [
                'time_label' => 'Ends On',
                // 'required' => false
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservePlaceDTO::class,
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

    public function getData(): ReservePlaceDTO
    {
        return new ReservePlaceDTO(
            $this->form->get('placeNo')->getData(),
            $this->form->get('carId')->getData(),
            $this->form->get('start')->getData(),
            $this->form->get('end')->getData()
        );
    }

    private function getCarsChoices(): array
    {
        /**
         * @var SecurityUserInterace user 
         */
        $user = $this->security->getUser();
        $cars = $this->carRepo->findBy(['owner' => $user->getUser()->getId()]);

        $choices = [];
        foreach ($cars as $car) {
            $choices[$car->getRegistrationNo()] = $car->getId();
        }
        return $choices;
    }
}
