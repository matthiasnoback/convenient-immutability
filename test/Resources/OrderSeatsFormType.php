<?php

namespace ConvenientImmutability\Test\Resources;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderSeatsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', ChoiceType::class, [
                'choices' => ['Matthias' => 1, 'Lucas' => 2]
            ])
            ->add('seatNumbers', ChoiceType::class, [
                'multiple' => true,
                'choices' => range(1, 10)
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderSeats::class
        ]);
    }

    public function getName()
    {
        return 'order_seats';
    }
}
