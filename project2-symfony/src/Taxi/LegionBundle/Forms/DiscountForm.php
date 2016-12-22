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
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints as Assert;


class DiscountForm extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
                'attr' => [
                    'placeholder' => 'Название',
                ],
            ])
            ->add('travel', TextType::class, [
                'label' => 'С какой и по какую поездку действует скидка (через запятую)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'С какой и по какую поездку действует скидка (через запятую)',
                ],
            ])
            ->add('abonent', EntityType::class, [
                'label' => 'Привязать скидку для',
                'required' => false,
                'placeholder' => 'всех абонентов',
                'class' => 'TaxiLegionBundle:Abonents',
                'choice_label' => function ($abonent) {
                    return $abonent->getName() . ' [+7' . $abonent->getPhone() . ']';
                },
                'data' => ($options['data']->getAbonent() ? $this->manager->getReference("TaxiLegionBundle:Abonents",$options['data']->getAbonent()) : ''),
            ])
            ->add('discount', NumberType::class, [
                'label' => 'Размер скидки (%)',
                'attr' => [
                    'placeholder' => 'Размер скидки (%)',
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