<?php

namespace Site\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Site\BackendBundle\Entity\NewsPost;
use Site\BackendBundle\Forms\NewsPostForm;
use Sonata\AdminBundle\Route\RouteCollection;

class NewsPostAdmin extends Admin
{
    protected $baseRoutePattern  = 'новости';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('list', 'список');
        $collection->add('create', 'создать');
        $collection->add('edit', $this->getRouterIdParameter().'/редактирование');
    }

    public function toString($object)
    {
        $object instanceof NewsPost;
        $title = 'Создание новости';

        if ($object->getTitle()) {
            $title = $object->getTitle();
        }

        return $title;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $builder = $formMapper->getFormBuilder()->getFormFactory()->createBuilder(NewsPostForm::class);

        $formMapper
            ->with('Новость')
            ->add($builder->get('title'))
            ->add($builder->get('media'))
            ->add($builder->get('mediaAnons'))
            ->add($builder->get('body'))
            ->add($builder->get('category'))
            ->add($builder->get('autor'))
            ->add($builder->get('date'))
            ->end()
        ;


    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $category = $this->getConfigurationPool()->getContainer()->get('Doctrine')->getManager()->getRepository('SiteBackendBundle:NewsCategory')->findBy([],['title' => 'asc']);

        $choices[] = 'Без категории';

        foreach ($category as $k => $v) {
            $choices[$v->getId()] = $v->getTitle();
        }

        $datagridMapper->add('title', null, ['label' => 'Заголовок']);
        $datagridMapper->add('category', 'doctrine_orm_string', [
            'label' => 'Категория',
        ], 'choice', [
            'choices' => $choices
        ]);

        $datagridMapper->add('autor', null, ['label' => 'Автор статьи']);

        $datagridMapper->add('date','doctrine_orm_date', [
            'label' => 'Дата',
        ]);

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $category = $this->getConfigurationPool()->getContainer()->get('Doctrine')->getManager()->getRepository('SiteBackendBundle:NewsCategory')->findBy([],['title' => 'asc']);

        $choices[] = 'Без категории';

        foreach ($category as $k => $v) {
            $choices[$v->getId()] = $v->getTitle();
        }

        $listMapper->addIdentifier('title', null, ['label' => 'Заголовок']);
        $listMapper->addIdentifier('category', 'choice', [
            'label' => 'Категория',
            'choices' => $choices
        ]);

        $listMapper->addIdentifier('autor', null, ['label' => 'Автор статьи']);

        $listMapper->addIdentifier('date', 'date', ['label' => 'Дата']);
    }

    public function prePersist($object)
    {

        $media = $object;
        $object instanceof NewsPost;
        if ($media->getMedia()) {
            $mediaManager = $this->getConfigurationPool()->getContainer()->get('sonata.media.manager.media');
            $mediaManager->save($media->getMedia());
            $object->setMedia($media->getMedia()->getId());
        }
        else {
            $object->setMedia('0');
        }

        $slug = preg_replace('/\W+/u', '-', mb_strtolower(trim(strip_tags($object->getTitle()))));

        $object->setSlug($slug);

    }

    public function preUpdate($object)
    {

        if ($object->getMedia()) {
            $id = $this->getSubject()->getMedia()->getId();

            if ($id) {
                $object->setMedia($id);
            }
            else {
                $mediaManager = $this->getConfigurationPool()->getContainer()->get('sonata.media.manager.media');
                $mediaManager->save($object->getMedia());
                $object->setMedia($object->getMedia()->getId());
            }
        }

        $slug = preg_replace('/\W+/u', '-', mb_strtolower(trim(strip_tags($object->getTitle()))));

        $object->setSlug($slug);

    }
}