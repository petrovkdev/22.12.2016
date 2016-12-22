<?php

namespace MfoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use MfoBundle\Entity\Services;
use MfoBundle\Forms\ServicesForm;

class ServicesAdmin extends Admin
{

    public function toString($object)
    {
        $object instanceof Services;
        $title = 'Создание услуги';

        if ($object->getName()) {
            $title = $object->getName();
        }

        return $title;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $builder = $formMapper->getFormBuilder()->getFormFactory()->createBuilder(ServicesForm::class);

        $formMapper
            ->with('Services')
            ->add($builder->get('name'))
            ->add($builder->get('media_id'))
            ->add($builder->get('gallery'))
            ->add($builder->get('content'))
            ->add($builder->get('seq_number'))
            ->end()
        ;


    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, ['label' => 'Название услуги']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', null, ['label' => 'Название услуги']);
    }

    public function prePersist($object)
    {

        $media = $object;
        $object instanceof Services;
        if ($media->getMediaId()) {
            $mediaManager = $this->getConfigurationPool()->getContainer()->get('sonata.media.manager.media');
            $mediaManager->save($media->getMediaId());
            $object->setMediaId($media->getMediaId()->getId());
        }
        else {
            $object->setMediaId('0');
        }
        
        
        if($object->getGallery()){
            $gallery = $object->getGallery()->getId();
            $object->setGallery($gallery);
        }
        else{
            $object->setGallery('0');
        }


    }

    public function preUpdate($object)
    {
        
        
        if($object->getGallery()){
            $gallery = $object->getGallery()->getId();
            $object->setGallery($gallery);
        }
        else{
            $object->setGallery('0');
        }
        
        
        if ($object->getMediaId()) {
            $id = $this->getSubject()->getMediaId()->getId();

            if ($id) {
                $object->setMediaId($id);
            }
            else {
                $mediaManager = $this->getConfigurationPool()->getContainer()->get('sonata.media.manager.media');
                $mediaManager->save($object->getMediaId());
                $object->setMediaId($object->getMediaId()->getId());
            }
        }



    }

}