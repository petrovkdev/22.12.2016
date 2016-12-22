<?php

namespace Taxi\LegionBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

class BlackUsersForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'ФИО',
                'attr' => [
                    'placeholder' => 'ФИО',
                    'class' => 'input-sm'
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон (вводить только цифры)',
                'attr' => [
                    'placeholder' => 'Телефон',
                    'maxlength' => 10,
                    'class' => 'input-sm'
                ],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Причина',
                'attr' => [
                    'placeholder' => 'Причина'
                ],
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Добавить',
                'attr' => [
                    'class' => 'btn-primary pull-right',
                    'data-loading-text' => 'подождите...'
                ]
            ]);
    }
}