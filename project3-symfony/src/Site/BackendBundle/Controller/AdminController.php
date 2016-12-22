<?php

namespace Site\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;
use Site\BackendBundle\Forms;

class AdminController extends CoreController
{

    /***
     * редактирование пользователя
     */
    function usereditAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('SiteBackendBundle:UserAdmin')->findOneBy(['id' => $id]);

        $form = $this->createForm(Forms\UserForm::class, $user);
        $request = Request::createFromGlobals();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $password = $encoder->encodePassword($form['password']->getData(), $user->getSalt());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('sonata_admin_dashboard');
        }

        return $this->render('SiteBackendBundle::user_edit.html.twig', [
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'form_edit_user' => $form->createView(),
        ]);
    }

    /**
     * Настройки сайта
     */
    function siteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $siteSettings = $em->getRepository('SiteBackendBundle:SiteSettings')->find('site');

        $form = $this->createForm(Forms\SiteSettingsForm::class, $siteSettings);
        $request = Request::createFromGlobals();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($siteSettings);
            $em->flush();

            return $this->redirectToRoute('site_settings');
        }

        return $this->render('SiteBackendBundle:Default:site_settings.html.twig', [
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'form_site' => $form->createView(),
        ]);
    }

    /**
     * фото дня
     */
    function photo_dayAction()
    {
        $em = $this->getDoctrine()->getManager();
        $photoDaySettings = $em->getRepository('SiteBackendBundle:PhotoDay')->find('photo_day');

        $form = $this->createForm(Forms\PhotoDayForm::class, $photoDaySettings);
        $request = Request::createFromGlobals();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(is_object($form['media']->getData())) {

                if ($photoDaySettings->getMedia() !== null) {
                    $mediaManager = $this->get('sonata.media.manager.media');
                    $mediaManager->save($form['media']->getData());
                    $photoDaySettings->setMedia($form['media']->getData()->getId());
                }
                else {
                    $photoDaySettings->setMedia($form['media']->getData()->getId());
                }
            }
            else {
                $photoDaySettings->setMedia(null);
            }



            $em->persist($photoDaySettings);
            $em->flush();

            return $this->redirectToRoute('photo_day_config');
        }

        return $this->render('SiteBackendBundle:Default:photo_day_config.html.twig', [
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'form' => $form->createView(),
        ]);
    }
}
