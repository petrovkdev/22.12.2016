<?php

namespace MfoBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Persistence\ObjectManager;
use MfoBundle\Forms\DataTransformer\MediaTransformer;

class MicrofinanceForm extends AbstractType
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
            ])
            ->add('media', 'sonata_media_type', [
                'required' => false,
                'label' => 'Файл (pdf)',
                'provider' => 'sonata.media.provider.file',
                'context'  => 'default',
                'new_on_update' => false,
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Категория',
                'choices' => $options['data'],
                'placeholder' => 'Выбрать категорию',
            ]);

        $builder->get('media')->addModelTransformer(new MediaTransformer($this->manager));
    }
}