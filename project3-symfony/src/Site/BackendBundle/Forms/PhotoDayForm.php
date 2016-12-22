<?php

namespace Site\BackendBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Persistence\ObjectManager;
use Site\BackendBundle\Forms\DataTransformer\MediaTransformer;

class PhotoDayForm extends AbstractType
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
                'required' => false,
                'attr' => [
                    'placeholder' => 'Название'
                ]
            ])
            ->add('media', 'sonata_media_type', [
                'required' => false,
                'label' => 'Изображение',
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default',
                'new_on_update' => false
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Включить/Выключить',
                'required' => false,
            ])
            ->add('save', SubmitType::class);

        $builder->get('media')->addModelTransformer(new MediaTransformer($this->manager));
    }
}