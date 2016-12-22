<?php

namespace Landing\PageBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints as Assert;

class CreditCalculatorForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('sum', NumberType::class, [
                'label' => 'Сумма',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Сумма',
                    'maxlength' => 7
                ],
                'constraints' => [ new Assert\LessThanOrEqual([
                            'value' => $options['data']['maxSum'],
                            'message' => "Максимум {{ compared_value }}.",
                        ]),
                        new Assert\NotBlank()
                    ]

            ])
            ->add('time', ChoiceType::class, [
                'choices'  =>  $options['data']['arrTime'],
                'label' => 'Срок',
                'placeholder' => '',
                'required' => true,
                'constraints' => [ new Assert\NotBlank() ]
            ])
            ->add('date', DateType::class, [
                'label' => 'Дата получения',
                'required' => true,
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'input' => 'timestamp',
                'attr' => [
                    'placeholder' => 'Дата получения',
                    'class' => 'datepicker',
                    'readonly' => true,
                    'value' => date('d.m.Y', time()),
                ],
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Рассчитать',
                'attr' => [
                    'class' => 'btn-success btn-block submit-calc prevent-default',
                    'data-loading-text' => "Подождите..."
                ]
            ]);
    }

}