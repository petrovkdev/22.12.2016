<?php

namespace MfoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use MfoBundle\Entity\Address;
use MfoBundle\Forms\AddressForm;

class AddressAdmin extends Admin
{
    public function toString($object)
    {
        $object instanceof Address;
        $title = 'Создание адреса';

        if ($object->getAddress()) {
            $title = $object->getAddress();
        }

        return $title;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $builder = $formMapper->getFormBuilder()->getFormFactory()->createBuilder(AddressForm::class);

        $formMapper
            ->with('Address')
            ->add($builder->get('office'))
            ->add($builder->get('address'))
            ->add($builder->get('phone'))
            ->add($builder->get('body'))
            ->end()
        ;


    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('address', null, ['label' => 'Адрес']);
        $datagridMapper->add('office', null, ['label' => 'Офис']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('address', null, ['label' => 'Адрес']);
        $listMapper->addIdentifier('office', null, ['label' => 'Офис']);
    }
}