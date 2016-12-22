<?php

namespace Taxi\LegionBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Assert;

class DriversForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'ФИО водителя',
                'attr' => [
                    'placeholder' => 'ФИО водителя'
                ],
            ])
            ->add('driverCall', NumberType::class, [
                'label' => 'Позывной',
                'attr' => [
                    'placeholder' => 'Позывной'
                ],
            ])
            ->add('driverMachine', TextType::class, [
                'label' => 'Регистрационный номер автомобиля',
                'attr' => [
                    'placeholder' => 'Регистрационный номер автомобиля'
                ],
            ])
            ->add('machineMarka', TextType::class, [
                'label' => 'Марка автомобиля',
                'attr' => [
                    'placeholder' => 'Марка автомобиля'
                ],
            ])
            ->add('machineColor', TextType::class, [
                'label' => 'Цвет автомобиля',
                'attr' => [
                    'placeholder' => 'Цвет автомобиля'
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон',
                'attr' => [
                    'placeholder' => 'Телефон'
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Адрес',
                'attr' => [
                    'placeholder' => 'Адрес'
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