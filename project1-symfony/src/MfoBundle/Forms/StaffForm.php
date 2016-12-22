<?php

namespace MfoBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Persistence\ObjectManager;
use MfoBundle\Forms\DataTransformer\MediaTransformer;

class StaffForm extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('userName', TextType::class, [
                'label' => 'Имя и Фамилия сотрудника',
            ])
            ->add('position', TextType::class, [
                'label' => 'Должность сотрудника',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон/Телефоны через запятую',
            ])
            ->add('educate', TextType::class, [
                'label' => 'Образование',
            ])
            ->add('media', 'sonata_media_type', [
                'required' => false,
                'label' => 'Фото сотрудника',
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default',
                'new_on_update' => false
            ])
            ->add('description', 'ckeditor', [
                'label' => 'Курируемые вопросы',
            ])
            ->add('seq_number', IntegerType::class, [
                'label' => 'Порядковый номер',
            ]);

        $builder->get('media')->addModelTransformer(new MediaTransformer($this->manager));
    }
}