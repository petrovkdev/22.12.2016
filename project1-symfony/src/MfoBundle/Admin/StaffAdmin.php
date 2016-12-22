<?php

namespace MfoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use MfoBundle\Entity\Staff;
use MfoBundle\Forms\StaffForm;

class StaffAdmin extends Admin
{
    public function toString($object)
    {
        $object instanceof Staff;
        $title = 'Создание сотрудника';

        if ($object->getUserName()) {
            $title = $object->getUserName();
        }

        return $title;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $builder = $formMapper->getFormBuilder()->getFormFactory()->createBuilder(StaffForm::class);

        $formMapper
            ->with('Staff')
            ->add($builder->get('userName'))
            ->add($builder->get('position'))
            ->add($builder->get('phone'))
            ->add($builder->get('educate'))
            ->add($builder->get('media'))
            ->add($builder->get('description'))
            ->add($builder->get('seq_number'))
            ->end()
        ;


    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('userName', null, ['label' => 'Имя и Фамилия сотрудника']);
        $datagridMapper->add('position', null, ['label' => 'Занимаемая должность']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('userName', null, ['label' => 'Имя и Фамилия сотрудника']);
        $listMapper->addIdentifier('position', null, ['label' => 'Занимаемая должность']);
    }

    public function prePersist($object)
    {

        $media = $object;
        $object instanceof Staff;
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