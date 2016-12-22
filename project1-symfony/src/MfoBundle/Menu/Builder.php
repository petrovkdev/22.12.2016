<?php
namespace MfoBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;


    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('admin');
        $menu->setChildrenAttributes(['class'=>'list-group left-menu-admin']);

        $menu->addChild('Администрирование');
        $menu['Администрирование']->addChild('Сайт', ['route' => 'admin_mfo_site']);

        $menu['Администрирование']->addChild('Калькулятор', ['route' => 'admin_mfo_calculator']);

        $menu->addChild('Блоки');
        $menu['Блоки']->addChild('Новости',['route' => 'admin_mfo_news_list']);
        $menu['Блоки']->addChild('Услуги',['route' => 'admin_mfo_services_list']);
        $menu['Блоки']->addChild('Микрофинансирование',['route' => 'admin_mfo_microfinance_list']);
        $menu['Блоки']->addChild('Информация',['route' => 'admin_mfo_information_list']);
        $menu['Блоки']->addChild('Сотрудники',['route' => 'admin_mfo_staff_list']);
        $menu['Блоки']->addChild('Адреса',['route' => 'admin_mfo_address_list']);

        $menu->addChild('Медиа');
        $menu['Медиа']->addChild('Менеджер файлов', ['route' => 'admin_sonata_media_media_list']);
        $menu['Медиа']->addChild('Менеджер галерей', ['route' => 'admin_sonata_media_gallery_list']);

        $route = $this->container->get('request')->get('_route');

        if ($route == 'admin_mfo_news_create' || $route == 'admin_mfo_news_edit') {
            $menu['Блоки']['Новости']->setAttributes(['class' => 'current']);
        }

        if ($route == 'admin_mfo_services_edit' || $route == 'admin_mfo_services_create') {
            $menu['Блоки']['Услуги']->setAttributes(['class' => 'current']);
        }

        if ($route == 'admin_mfo_microfinance_edit' || $route == 'admin_mfo_microfinance_create') {
            $menu['Блоки']['Микрофинансирование']->setAttributes(['class' => 'current']);
        }

        if ($route == 'admin_mfo_information_edit' || $route == 'admin_mfo_information_create') {
            $menu['Блоки']['Информация']->setAttributes(['class' => 'current']);
        }

        if ($route == 'admin_mfo_staff_edit' || $route == 'admin_mfo_staff_create') {
            $menu['Блоки']['Сотрудники']->setAttributes(['class' => 'current']);
        }

        if ($route == 'admin_mfo_address_edit' || $route == 'admin_mfo_address_create') {
            $menu['Блоки']['Адреса']->setAttributes(['class' => 'current']);
        }

        return $menu;
    }


}