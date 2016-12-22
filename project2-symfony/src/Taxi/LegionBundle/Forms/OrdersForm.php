<?php

namespace Taxi\LegionBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;

class OrdersForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Телефон',
                    'class' => 'input-sm',
                    'maxlength' => 10
                ],
            ])
            ->add('user', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'ФИО заказчика / Наименование организации',
                    'class' => 'input-sm'
                ],
            ])
            ->add('streetSource', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Улица',
                    'class' => 'input-sm'
                ],
            ])
            ->add('houseNumberSource', NumberType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Дом',
                    'class' => 'input-sm'
                ],
            ])
            ->add('porchSource', NumberType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Подъезд',
                    'class' => 'input-sm'
                ],
            ])
            ->add('streetDest', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Улица',
                    'class' => 'input-sm'
                ],
            ])
            ->add('houseNumberDest', NumberType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Дом',
                    'class' => 'input-sm'
                ],
            ])
            ->add('porchDest', NumberType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Подъезд',
                    'class' => 'input-sm'
                ],
            ])
            ->add('driver', EntityType::class, [
                'label' => false,
                'placeholder' => 'Выбрать водителя',
                'class' => 'TaxiLegionBundle:Drivers',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'input-sm'
                ],
            ])
            ->add('area', EntityType::class, [
                'label' => false,
                'placeholder' => 'Выбрать территориальную зону',
                'class' => 'TaxiLegionBundle:AreaOrder',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'input-sm'
                ],
            ])
            ->add('childSeat', ChoiceType::class, [
                'label' => false,
                'choices' => ['Детское кресло' => true],
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('luggage', ChoiceType::class, [
                'label' => false,
                'choices' => ['Перегруз' => true],
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('prior', ChoiceType::class, [
                'label' => false,
                'choices' => ['Предварительный заказ' => true],
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('priorTime', DateTimeType::class, [
                'label' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd.MM.yyyy HH:mm',
                'attr' => ['class' => 'input-sm'],
                'read_only' => true
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Создать',
                'attr' => [
                    'class' => 'btn-primary pull-right order-save',
                    'data-loading-text' => 'подождите...',
                    'data-action' => 'add_taxi_order'
                ]
            ]);
    }
}