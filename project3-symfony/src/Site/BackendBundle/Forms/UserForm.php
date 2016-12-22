<?php
namespace Site\BackendBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', TextType::class, [
                'label' => 'Логин',
                'attr' => [
                    'placeholder' => 'Логин'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'attr' => [
                    'placeholder' => 'Пароль'
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