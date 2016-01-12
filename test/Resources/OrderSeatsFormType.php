<?php

namespace ConvenientImmutability\Test\Resources;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderSeatsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', 'choice', [
                'choices' => [1 => 'Matthias', 2 => 'Lucas']
            ])
            ->add('seatNumbers', 'choice', [
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
