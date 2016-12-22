<?php

namespace Taxi\LegionBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints as Assert;

class ConfigForm extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('tariff', EntityType::class, [
                'label' => 'Действующий тариф',
                'placeholder' => 'Действующий тариф',
                'class' => 'TaxiLegionBundle:Tariffs',
                'choice_label' => 'name',
                'data' => $this->manager->getReference("TaxiLegionBundle:Tariffs",$options['data']->getTariff()),
                'attr' => [
                    'class' => 'input-sm'
                ],
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Применить',
                'attr' => [
                    'class' => 'btn-primary pull-right'
                ]
            ]);
    }
}