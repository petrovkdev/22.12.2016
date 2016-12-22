<?php

namespace MfoBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class AddressForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('office', TextType::class, [
                'label' => 'Офис',
            ])
            ->add('address', TextType::class, [
                'label' => 'Адрес',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон/Телефоны (через запятую)',
                'required' => false
            ])
            ->add('body', 'ckeditor', [
                'label' => 'Дополнительно',
            ]);

    }
}