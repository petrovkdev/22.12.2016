<?php
namespace MfoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use MfoBundle\Entity\News;

class NewsAdmin extends Admin
{

    public function toString($object)
    {
        $object instanceof News;
        $title = 'Создание новости';

        if ($object->getTitle()) {
            $title = $object->getTitle();
        }

        return $title;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', 'text', ['label' => 'Заголовок']);
        $formMapper->add('content', 'ckeditor',['label' => 'Содержание']);
        $formMapper->add('date', 'sonata_type_date_picker', [
            'label' => 'Дата',
            'attr' => [
                'readonly' => true
            ],
            'format'=>'d.M.y',
            'dp_default_date' => date('d.m.Y', time()),
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title', null, ['label' => 'Заголовок']);
        $datagridMapper->add('date','doctrine_orm_date', [
            'label' => 'Дата',
        ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title', null, ['label' => 'Заголовок']);
        $listMapper->addIdentifier('date', 'date', ['label' => 'Дата']);
    }



}
