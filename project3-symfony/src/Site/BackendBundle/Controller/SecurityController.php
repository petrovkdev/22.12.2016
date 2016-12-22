<?php

namespace Site\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController  extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $login = $authenticationUtils->getLastUsername();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_SONATA_ADMIN')) {
            return $this->redirectToRoute('sonata_admin_dashboard');
        }

        return $this->render('SiteBackendBundle:Default:login.html.twig', array(
            'login' => $login,
            'error' => $error,
        ));
    }
}