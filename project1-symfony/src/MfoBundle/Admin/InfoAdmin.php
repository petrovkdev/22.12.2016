<?php

namespace MfoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use MfoBundle\Entity\Information;
use MfoBundle\Forms\InfoForm;

class InfoAdmin extends Admin
{
    public function toString($object)
    {
        $object instanceof Information;
        $title = 'Создание';

        if ($object->getTitle()) {
            $title = $object->getTitle();
        }

        return $title;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $builder = $formMapper->getFormBuilder()->getFormFactory()->createBuilder(InfoForm::class);

        $formMapper
            ->with('Info')
            ->add($builder->get('title'))
            ->add($builder->get('body'))
            ->end()
        ;


    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title', null, ['label' => 'Название']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title', null, ['label' => 'Название']);
    }
}