<?php

namespace Site\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('SiteBackendBundle:NewsPost')
            ->createQueryBuilder('p')
            ->select('p.title title, p.media media, p.body body, p.date date, c.title category, c.slug category_slug, p.slug slug, p.autor autor')
            ->leftJoin('SiteBackendBundle:NewsCategory', 'c', 'WITH', 'p.category = c.id')
            ->orderBy('p.date', 'DESC')
            ->setMaxResults(10)
            ->getQuery();

        return $this->render('SiteFrontendBundle:Default:index.html.twig', [
            'news' => $news->getResult(),
        ]);
    }

    public function newsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('SiteBackendBundle:NewsPost')->findBy(['category' => 0],['date' => 'desc'],10);

        return $this->render('SiteFrontendBundle:Default:news.html.twig', [
            'news' => $news,
            'title' => 'Новости',
            'path_route' => 'news_post'
        ]);
    }

    public function categoryAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('SiteBackendBundle:NewsCategory')->findOneBy(['slug' => $slug]);

        if(!$category) {
            throw new NotFoundHttpException('Sorry not existing!');
        }

        $news = $em->getRepository('SiteBackendBundle:NewsPost')->findBy(['category' => $category->getid()],['date' => 'desc'],10);


        return $this->render('SiteFrontendBundle:Default:news.html.twig', [
            'news' => $news,
            'title' => $category->getTitle(),
            'category_slug' => $category->getSlug(),
            'path_route' => 'news_category_post',
        ]);
    }

    public function news_postAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('SiteBackendBundle:NewsPost')->findOneBy(['slug' => $slug]);

        if(!$post || $post->getCategory() != 0) {
            throw new NotFoundHttpException('Sorry not existing!');
        }

        return $this->render('SiteFrontendBundle:Default:post.html.twig', [
            'post' => $post
        ]);
    }

    public function news_category_postAction($category_slug,$slug)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('SiteBackendBundle:NewsPost')->findOneBy(['slug' => $slug]);

        $category = $em->getRepository('SiteBackendBundle:NewsCategory')->findOneBy(['slug' => $category_slug]);

        if(!$post || $post->getCategory() == 0 || $post->getCategory() != $category->getId()) {
            throw new NotFoundHttpException('Sorry not existing!');
        }

        return $this->render('SiteFrontendBundle:Default:post.html.twig', [
            'post' => $post,
            'category_slug' => $category_slug,
            'category_title' => $category->getTitle()

        ]);
    }
}
