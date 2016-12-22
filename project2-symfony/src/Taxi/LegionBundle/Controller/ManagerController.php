<?php

namespace Taxi\LegionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Taxi\LegionBundle\Forms;
use Taxi\LegionBundle\Entity;

class ManagerController extends Controller
{
    /**
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function referencesAction()
    {
        return $this->render('TaxiLegionBundle:Manager:references.html.twig');
    }

    /***
     * ajax
     */
    function ajaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            $formClassDir = 'Taxi\LegionBundle\Forms';

            switch ($request->get('action')) {

                case 'show_form_black_users':
                    $blackUsersForm = $this->createForm(Forms\BlackUsersForm::class);
                    return new JsonResponse([
                        'view' => $this->renderView('TaxiLegionBundle:Manager/Modal:modal.html.twig', [
                            'size_modal' => false,
                            'content'    => $this->renderView('TaxiLegionBundle:Manager/Form:black_users_form.html.twig',[
                                'form'    => $blackUsersForm->createView(),
                            ])
                        ])
                    ]);

                    break;

                case 'add_user_black_list':
                    $blackUsers = new Entity\BlackUsers();

                    $form = $this->createForm(Forms\BlackUsersForm::class, $blackUsers);

                    $form->handleRequest($request);

                    if ($form->isSubmitted() && $form->isValid()) {

                        $blackUsers->setDate(new \DateTime('now'));
                        $em->persist($blackUsers);
                        $em->flush();

                        $alert = $this->renderView('TaxiLegionBundle:Manager/Alert:alert.html.twig',[
                            'type_alert' => ' alert-success',
                            'text_alert' => ['Телефон +7'.$form->get('phone')->getData().' добавлен в черный список'],
                        ]);
                        return new JsonResponse([
                            'success' => $alert
                        ]);
                    }
                    else {

                        $errors     = $form->getErrors(true);
                        $errorsList = [];

                        foreach ($errors as $error) {
                            $errorsList[] = $error->getMessage();
                        }

                        $alert = $this->renderView('TaxiLegionBundle:Manager/Alert:alert.html.twig',[
                                        'type_alert' => ' alert-danger',
                                        'text_alert' => $errorsList,
                                ]);

                        return new JsonResponse([
                            'error' => $alert
                        ]);
                    }

                    break;

                case 'show_order_form':
                    $orderForm = $this->createForm(Forms\OrdersForm::class);
                    return new JsonResponse([
                        'view' => $this->renderView('TaxiLegionBundle:Manager/Modal:modal.html.twig', [
                            'size_modal' => '',
                            'content'    => $this->renderView('TaxiLegionBundle:Manager/Form:order_form.html.twig',[
                                'form'    => $orderForm->createView(),
                            ])
                        ])
                    ]);

                    break;

                case 'show_form':

                    $class = trim($request->get('obj'));

                    $orderForm = $this->createForm($formClassDir . $class);

                    $tpl = $request->get('tpl');

                    return new JsonResponse([
                        'view' => $this->renderView('TaxiLegionBundle:Manager/Ajax:' . $tpl,[
                                'form'    => $orderForm->createView(),
                            ])
                        ]);

                    break;

                case 'add_taxi_order':

                    $orders = new Entity\Orders();
                    $streetSource = new Entity\Streets();
                    $streetDest = new Entity\Streets();
                    $abonent = new Entity\Abonents();

                    $form = $this->createForm(Forms\OrdersForm::class, $orders);

                    $form->handleRequest($request);

                    if ($form->isSubmitted() && $form->isValid()) {

                        $orders->setManager($this->getUser()->getId());
                        $orders->setDiscount(0);
                        $orders->setTypeOrder(1);
                        $orders->setDriver($form->get('driver')->getData()->getId());
                        $orders->setArea($form->get('area')->getData()->getId());
                        $orders->setCreateOrderTime(new \DateTime('now'));
                        $em->persist($orders);

                        if ($form->get('streetSource')->getData()) {
                            $getStreetSource = $em->getRepository('TaxiLegionBundle:Streets')->findOneBy(['name' => trim($form->get('streetSource')->getData())]);

                            if (!$getStreetSource) {
                                $streetSource->setName(trim($form->get('streetSource')->getData()));
                                $em->persist($streetSource);
                            }
                        }


                        if ($form->get('streetDest')->getData()) {
                            $getStreetDest = $em->getRepository('TaxiLegionBundle:Streets')->findOneBy(['name' => trim($form->get('streetDest')->getData())]);

                            if (!$getStreetDest) {
                                $streetDest->setName(trim($form->get('streetDest')->getData()));
                                $em->persist($streetDest);
                            }

                        }

                        if ($form->get('phone')->getData()) {

                            $repAbonent = $em->getRepository('TaxiLegionBundle:Abonents')->findOneBy(['phone' => trim($form->get('phone')->getData())]);

                            if (!$repAbonent) {
                                $abonent->setName(trim($form->get('user')->getData()));
                                $abonent->setPhone(trim($form->get('phone')->getData()));
                                $em->persist($abonent);
                            }

                        }

                        $em->flush();

                        $alert = $this->renderView('TaxiLegionBundle:Manager/Alert:alert.html.twig',[
                            'type_alert' => ' alert-success',
                            'text_alert' => ['Заказ успешно создан'],
                        ]);

                        return new JsonResponse([
                            'success' => $alert
                        ]);
                    }
                    else {

                        $error = $this->renderView('TaxiLegionBundle:Manager/Ajax:order_taxi_form.html.twig',[
                            'form' => $form->createView(),
                        ]);

                        return new JsonResponse([
                            'error' => $error
                        ]);
                    }

                    break;

                case 'add_delivery_order':

                    $orders = new Entity\Orders();
                    $streetSource = new Entity\Streets();
                    $abonent = new Entity\Abonents();

                    $form = $this->createForm(Forms\DelivOrderForm::class, $orders);

                    $form->handleRequest($request);

                    if ($form->isSubmitted() && $form->isValid()) {

                        $orders->setManager($this->getUser()->getId());
                        $orders->setDiscount(0);
                        $orders->setTypeOrder(2);
                        $orders->setDriver($form->get('driver')->getData()->getId());
                        $orders->setArea($form->get('area')->getData()->getId());
                        $orders->setCreateOrderTime(new \DateTime('now'));
                        $em->persist($orders);

                        if ($form->get('streetSource')->getData()) {
                            $getStreetSource = $em->getRepository('TaxiLegionBundle:Streets')->findOneBy(['name' => trim($form->get('streetSource')->getData())]);

                            if (!$getStreetSource) {
                                $streetSource->setName(trim($form->get('streetSource')->getData()));
                                $em->persist($streetSource);
                            }
                        }

                        if ($form->get('phone')->getData()) {

                            $repAbonent = $em->getRepository('TaxiLegionBundle:Abonents')->findOneBy(['phone' => trim($form->get('phone')->getData())]);

                            if (!$repAbonent) {
                                $abonent->setName(trim($form->get('user')->getData()));
                                $abonent->setPhone(trim($form->get('phone')->getData()));
                                $em->persist($abonent);
                            }

                        }

                        $em->flush();

                        $alert = $this->renderView('TaxiLegionBundle:Manager/Alert:alert.html.twig',[
                            'type_alert' => ' alert-success',
                            'text_alert' => ['Заказ успешно создан'],
                        ]);

                        return new JsonResponse([
                            'success' => $alert
                        ]);
                    }
                    else {

                        $error = $this->renderView('TaxiLegionBundle:Manager/Ajax:order_delivery_form.html.twig',[
                            'form' => $form->createView(),
                        ]);

                        return new JsonResponse([
                            'error' => $error
                        ]);
                    }

                    break;

                case 'show_table':

                    $tpl = trim($request->get('tpl'));
                    $obj = trim($request->get('obj'));
                    $sort = trim($request->get('sort'));

                    $result = $em->getRepository('TaxiLegionBundle:' . $obj)->findBy([],[$sort => 'asc']);

                    $view = $this->renderView('TaxiLegionBundle:Manager/Ajax:' . $tpl,[
                        'result' => $result,
                    ]);

                    return new JsonResponse([
                        'view' => $view
                    ]);

                    break;
            }
        }
    }
}