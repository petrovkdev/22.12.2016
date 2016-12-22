<?php


namespace Site\FrontendBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Knp\Menu\Renderer\ListRenderer;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;


    public function siteMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('site');
        $menu->setChildrenAttributes(['class'=>'nav pull-left clearfix']);

        $menu->addChild('рубрики', ['uri' => '#'])
            ->setAttributes([
                'class' => 'dropdown pull-left'
            ]);

        $menu['рубрики']
            ->setLinkAttribute('class','dropdown-toggle')
            ->setLinkAttribute('data-toggle', 'dropdown')
            ->setChildrenAttributes(['class'=>'dropdown-menu']);

        $em = $this->container->get('doctrine')->getManager();

        $category = $em->getRepository('SiteBackendBundle:NewsCategory')->findBy([],['title' => 'asc']);

        $post = $em->getRepository('SiteBackendBundle:NewsPost');

        foreach ($category as $item) {

            $count = $post->createQueryBuilder('p')
                ->select('count(p)')
                ->where('p.category = :cat')
                ->setParameter('cat', $item->getId())
                ->getQuery()
                ->getSingleScalarResult();

            if ($count) {
                $menu['рубрики']->addChild($item->getTitle(), ['route' => 'category', 'routeParameters' => ['slug' => $item->getSlug()]],'<p></p>')->setAttributes(['class' => 'pull-left dropdown-item']);
                $menu['рубрики'][$item->getTitle()]->addChild($count)->setChildrenAttributes(['class' => 'list-unstyled']);
                $menu['рубрики'][$item->getTitle()]->setChildrenAttributes(['class' => 'list-unstyled badge app-badge pull-right']);
            }

        }

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $menu->addChild('рекламодателям', ['route' => 'site_frontend_homepage'])->setAttributes(['class' => 'pull-left']);
        $menu->addChild('фото', ['route' => 'site_frontend_homepage'])->setAttributes(['class' => 'pull-left']);
        $menu->addChild('видео', ['route' => 'site_frontend_homepage'])->setAttributes(['class' => 'pull-left']);
        $menu->addChild('контакты', ['route' => 'site_frontend_homepage'])->setAttributes(['class' => 'pull-left']);


        $route = $this->container->get('request_stack')->getMasterRequest()->attributes->get('_route');


        return $menu;
    }

}