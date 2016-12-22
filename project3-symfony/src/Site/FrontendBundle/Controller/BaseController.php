<?php

namespace Site\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Site\FrontendBundle\Forms;

class BaseController extends Controller
{
    /**
     * @return Response
     * get header
     */
    public function headerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $siteSettings = $em->getRepository('SiteBackendBundle:SiteSettings')->find('site');

        return $this->render('SiteFrontendBundle:Base:header.html.twig',[
            'address' => $siteSettings->getAddress(),
            'phone'   => $siteSettings->getPhone(),
            'email'   => $siteSettings->getEmail(),
            'time'    => time(),
        ]);
    }

    /**
     * get title site
     */
    public function titleAction()
    {
        $em = $this->getDoctrine()->getManager();
        $siteSettings = $em->getRepository('SiteBackendBundle:SiteSettings')->find('site');

        return new Response($siteSettings->getTitle());
    }

    /**
     * get title site
     */
    public function navAction($route)
    {
        $form = $this->createForm(Forms\SearchForm::class);
        $request = Request::createFromGlobals();
        $form->handleRequest($request);
        return $this->render('SiteFrontendBundle:Base:nav.html.twig',[
            'route' => $route,
            'form' => $form->createView(),
        ]);
    }

    /**
     * get id media - photo day
     */
    public function media_photo_dayAction(Request $request,$route)
    {
        $em = $this->getDoctrine()->getManager();
        $photoDaySettings = $em->getRepository('SiteBackendBundle:PhotoDay')->find('photo_day');

        return new JsonResponse([
            'name' => $photoDaySettings->getName(),
            'media' => $photoDaySettings->getMedia(),
            'enabled' => $photoDaySettings->getEnabled()
        ]);
    }

    /**
     * get news
     */
    public function newsAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('SiteBackendBundle:NewsPost')->findBy(['category' => 0],['date' => 'desc'], 10);

        $view = $this->renderView('SiteFrontendBundle:Layouts:list_news.html.twig', [
            'news' => $news,
            'slug' => $slug
        ]);

        return new Response($view);
    }
}