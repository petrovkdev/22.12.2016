<?php

namespace Taxi\LegionBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class TariffForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название тарифа',
                'attr' => [
                    'placeholder' => 'Название тарифа',
                ],
            ])
            ->add('price', NumberType::class, [
                'label' => 'Цена за 1 км',
                'attr' => [
                    'placeholder' => 'Цена за 1 км',
                ],
            ])
            ->add('price_pending', NumberType::class, [
                'label' => 'Цена за 1 мин. простоя',
                'attr' => [
                    'placeholder' => 'Цена за 1 мин. простоя',
                ],
            ])
            ->add('price_overdrive', NumberType::class, [
                'label' => 'Цена за перегруз',
                'attr' => [
                    'placeholder' => 'Цена за перегруз',
                ],
            ])
            ->add('start_counter', NumberType::class, [
                'label' => 'Старт счетчика',
                'attr' => [
                    'placeholder' => 'Старт счетчика',
                ],
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn-primary',
                ]
            ]);
    }
}