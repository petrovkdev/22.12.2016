<?php

namespace MfoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use MfoBundle\Entity\Microfinance;
use MfoBundle\Forms\MicrofinanceForm;

class MicrofinanceAdmin extends Admin
{

    public function toString($object)
    {
        $object instanceof Microfinance;
        $title = 'Создание позиции';

        if ($object->getName()) {
            $title = $object->getName();
        }

        return $title;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $option = $this->getConfigurationPool()->getContainer()->getParameter('mfo')['category'];

        $builder = $formMapper->getFormBuilder()->getFormFactory()->createBuilder(MicrofinanceForm::class, $option);

        $formMapper
            ->with('Microfinance')
            ->add($builder->get('name'))
            ->add($builder->get('media'))
            ->add($builder->get('category'))
            ->end()
        ;


    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $option = $this->getConfigurationPool()->getContainer()->getParameter('mfo')['category'];
        $datagridMapper->add('name', null, ['label' => 'Название']);
        $datagridMapper->add('category', 'doctrine_orm_string', [
            'label' => 'Категория',
        ], 'choice', [
            'choices' => $option
        ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $option = $this->getConfigurationPool()->getContainer()->getParameter('mfo')['category'];
        $listMapper->addIdentifier('name', null, ['label' => 'Название']);
        $listMapper->addIdentifier('category', 'choice', [
            'label' => 'Категория',
            'choices' => $option
        ]);
    }

    public function prePersist($object)
    {

        $media = $object;
        $object instanceof Microfinance;
        if ($media->getMedia()) {
            $mediaManager = $this->getConfigurationPool()->getContainer()->get('sonata.media.manager.media');
            $mediaManager->save($media->getMedia());
            $object->setMedia($media->getMedia()->getId());
        }
        else {
            $object->setMedia('0');
        }


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



    }
}