<?php

namespace Taxi\LegionBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Assert;

class AreaOrdersForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
                'attr' => [
                    'placeholder' => 'Название'
                ],
            ])
            ->add('adjustment', NumberType::class, [
                'label' => 'Наценка',
                'attr' => [
                    'placeholder' => 'Наценка',
                ]
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn-primary'
                ]
            ]);
    }
}