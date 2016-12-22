<?php
namespace Site\BackendBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;


    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('admin');
        $menu->setChildrenAttributes(['class'=>'list-group left-menu-admin']);

        $menu->addChild('Администрирование');
        $menu['Администрирование']->addChild('Настройки сайта', ['route' => 'site_settings']);

        $menu->addChild('Разделы');
        $menu['Разделы']->addChild('Фото дня',['route' => 'photo_day_config']);




        $route = $this->container->get('request')->get('_route');


        
        return $menu;
    }


}