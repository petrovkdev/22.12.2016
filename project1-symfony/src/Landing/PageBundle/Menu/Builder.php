<?php
namespace Landing\PageBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;


    public function siteMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('site');
        $menu->setChildrenAttributes(['class'=>'nav navbar-nav']);

        $menu->addChild('Займы', ['uri' => '#loans'])->setAttributes(['class' => 'active prevent-default']);
        $menu->addChild('Новости', ['uri' => '#news'])->setAttributes(['class' => 'prevent-default']);
        $menu->addChild('Услуги', ['uri' => '#services'])->setAttributes(['class' => 'prevent-default']);
        $menu->addChild('Микрофинансирование', ['uri' => '#microfinance'])->setAttributes(['class' => 'prevent-default']);
        $menu->addChild('Информация', ['uri' => '#info'])->setAttributes(['class' => 'prevent-default']);
        $menu->addChild('Сотрудники', ['uri' => '#staff'])->setAttributes(['class' => 'prevent-default']);
        $menu->addChild('Адреса', ['uri' => '#addresses'])->setAttributes(['class' => 'prevent-default']);
        
        return $menu;
    }

}