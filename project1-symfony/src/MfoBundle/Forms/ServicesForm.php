<?php

namespace MfoBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Persistence\ObjectManager;
use MfoBundle\Forms\DataTransformer\MediaTransformer;
use MfoBundle\Forms\DataTransformer\GalleryTransformer;

class ServicesForm extends AbstractType
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
                'label' => 'Название услуги',
            ])
            ->add('media_id', 'sonata_media_type', [
                'required' => false,
                'label' => 'Изображение',
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default',
                'new_on_update' => false
            ])
            ->add('gallery', EntityType::class, [
                'label' => 'Выбрать галлерею',
                'required' => false,
                'placeholder' => 'Выбрать галлерею',
                'class' => 'ApplicationSonataMediaBundle:Gallery',
                'choice_label' => 'name',
            ])
            ->add('content', 'ckeditor', [
                'label' => 'Содержание',
            ])
            ->add('seq_number', IntegerType::class, [
                'label' => 'Порядковый номер',
            ]);

        $builder->get('media_id')->addModelTransformer(new MediaTransformer($this->manager));
        $builder->get('gallery')->addModelTransformer(new GalleryTransformer($this->manager));
    }
}