<?php

namespace Site\BackendBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Persistence\ObjectManager;
use Site\BackendBundle\Forms\DataTransformer\MediaTransformer;

class NewsPostForm extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $category = $this->manager->getRepository('SiteBackendBundle:NewsCategory')->findBy([],['title' => 'asc']);

        $choices[] = 'Без категории';

        foreach ($category as $k => $v) {
            $choices[$v->getId()] = $v->getTitle();
        }


        $builder
            ->add('title', TextType::class, [
                'label' => 'Заголовок',
            ])
            ->add('media', 'sonata_media_type', [
                'required' => false,
                'label' => 'Изображение',
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default',
                'new_on_update' => false
            ])
            ->add('mediaAnons', CheckboxType::class, [
                'label' => 'Выводить изображение только в анонсе',
                'required' => false
            ])
            ->add('body', 'ckeditor', [
                'label' => 'Содержание',
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Категория',
                'choices' => $choices,
                'placeholder' => 'Выбрать категорию',
            ])
            ->add('autor', TextType::class, [
                'label' => 'Автор статьи',
                'required' => false
            ])
            ->add('date', 'sonata_type_date_picker', [
                'label' => 'Дата',
                'attr' => [
                    'readonly' => true
                ],
                'format'=>'d.M.y',
                'dp_default_date' => date('d.m.Y', time()),
            ]);

        $builder->get('media')->addModelTransformer(new MediaTransformer($this->manager));
    }
}