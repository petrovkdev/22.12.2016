<?php

namespace Site\BackendBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewsCategoryForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, [
                'label' => 'Название рубрики',
                'attr' => [
                    'placeholder' => 'Название рубрики'
                ]
            ]);
    }
}