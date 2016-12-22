<?php

namespace Site\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Site\BackendBundle\Entity\NewsCategory;
use Site\BackendBundle\Forms\NewsCategoryForm;
use Sonata\AdminBundle\Route\RouteCollection;

class NewsCategoryAdmin extends Admin
{
    protected $baseRoutePattern  = 'рубрики';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('list', 'список');
        $collection->add('create', 'создать');
        $collection->add('edit', $this->getRouterIdParameter().'/редактирование');
    }

    public function toString($object)
    {
        $object instanceof NewsCategory;
        $title = 'Создание рубрики';

        if ($object->getTitle()) {
            $title = $object->getTitle();
        }

        return $title;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $builder = $formMapper->getFormBuilder()->getFormFactory()->createBuilder(NewsCategoryForm::class);

        $formMapper
            ->with('Рубрика')
            ->add($builder->get('title'))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title', null, ['label' => 'Название рубрики']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title', null, ['label' => 'Название рубрики']);
    }

    public function prePersist($object)
    {

        $slug = preg_replace('/\W+/u', '-', mb_strtolower(trim(strip_tags($object->getTitle()))));

        $object->setSlug($slug);
    }

    public function preUpdate($object)
    {
        $slug = preg_replace('/\W+/u', '-', mb_strtolower(trim(strip_tags($object->getTitle()))));

        $object->setSlug($slug);

    }
}