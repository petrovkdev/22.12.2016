<?php
namespace Site\BackendBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class SiteSettingsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, [
                'label' => 'Название',
                'attr' => [
                    'placeholder' => 'Название'
                ]
            ])
            ->add('copy', TextType::class, [
                'label' => 'Копирайт',
                'attr' => [
                    'placeholder' => 'Копирайт'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Адрес',
                'attr' => [
                    'placeholder' => 'Адрес',
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон',
                'attr' => [
                    'placeholder' => 'Телефон',
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Электронная почта',
                'attr' => [
                    'placeholder' => 'Электронная почта',
                ]
            ])
            ->add('save', SubmitType::class);
    }
}