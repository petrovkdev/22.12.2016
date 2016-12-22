<?php
namespace Taxi\LegionBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('admin');
        $menu->setChildrenAttributes(['class'=>'nav navbar-nav']);
        $menu->addChild('Пользователи', array('route' => 'taxi_legion_users'));
        $menu->addChild('Тарифы', array('route' => 'taxi_legion_tariffs'));
        $menu->addChild('Скидки', array('route' => 'taxi_legion_discount'));
        $menu->addChild('Водители', array('route' => 'taxi_legion_drivers'));
        $menu->addChild('Типы заявок', array('route' => 'taxi_legion_type_order'));
        $menu->addChild('Территориальные зоны', array('route' => 'taxi_legion_area'));
        $menu->addChild('Журналы', array('route' => 'taxi_legion_logbook'));

        $route = $this->container->get('request')->get('_route');

        if($route == 'taxi_legion_users_create' || $route == 'taxi_legion_user_edit')
        {
            $menu['Пользователи']->setLinkAttribute('class', 'active');
        }

        if($route == 'taxi_legion_tariff_create' || $route == 'taxi_legion_tariff_edit')
        {
            $menu['Тарифы']->setLinkAttribute('class', 'active');
        }

        if($route == 'taxi_legion_drivers_create' || $route == 'taxi_legion_drivers_edit')
        {
            $menu['Водители']->setLinkAttribute('class', 'active');
        }

        if($route == 'taxi_legion_type_order_create' || $route == 'taxi_legion_type_order_edit')
        {
            $menu['Типы заявок']->setLinkAttribute('class', 'active');
        }

        if($route == 'taxi_legion_area_create' || $route == 'taxi_legion_area_edit')
        {
            $menu['Территориальные зоны']->setLinkAttribute('class', 'active');
        }

        if($route == 'taxi_legion_discount_create' || $route == 'taxi_legion_discount_edit')
        {
            $menu['Скидки']->setLinkAttribute('class', 'active');
        }
        
        return $menu;
    }

    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function adminSysMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('sysadmin');
        $menu->setChildrenAttributes(['class'=>'nav navbar-nav']);

        $route = $this->container->get('request')->get('_route');

        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $menu->addChild('Профиль', array('route' => 'fos_user_profile_show'));
            $menu['Профиль']->setLinkAttribute('class', 'profile');

            if($route == 'fos_user_profile_edit')
            {
                $menu['Профиль']->setLinkAttribute('class', 'active');
            }
        }

        $menu->addChild('Выход', array('route' => 'fos_user_security_logout'));

        $menu['Выход']->setLinkAttribute('class','logout');

        return $menu;
    }

    /**
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function managerMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('admin');
        $menu->setChildrenAttributes(['class'=>'nav navbar-nav']);

        $route = $this->container->get('request')->get('_route');

        $menu->addChild('Справочники', array('route' => 'taxi_legion_references'));

        return $menu;
    }
}