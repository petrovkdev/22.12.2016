<?php

namespace Taxi\LegionBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Taxi\LegionBundle\Entity\User as TaxiUser;
use Taxi\LegionBundle\Entity\Tariffs as TaxiTariffs;
use Taxi\LegionBundle\Entity\Drivers as TaxiDrivers;
use Taxi\LegionBundle\Entity\TypeOrder;
use Taxi\LegionBundle\Entity\AreaOrder;
use Taxi\LegionBundle\Entity\Config;
use Taxi\LegionBundle\Entity\Discount;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Taxi\LegionBundle\Forms\TariffForm;
use Taxi\LegionBundle\Forms\DriversForm;
use Taxi\LegionBundle\Forms\TypeOrdersForm;
use Taxi\LegionBundle\Forms\AreaOrdersForm;
use Taxi\LegionBundle\Forms\ConfigForm;
use Taxi\LegionBundle\Forms\DiscountForm;


class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_MANAGER')")
     * главная страница
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_MANAGER')) {
            $tmp = $this->render('TaxiLegionBundle:Manager:index.html.twig');
        }
        else {


            $cfg = $em->getRepository('TaxiLegionBundle:Config')->find('config');


            $form = $this->createForm(ConfigForm::class, $cfg);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $cfg->setTariff($form->get('tariff')->getData()->getId());
                $em->persist($cfg);
                $em->flush();
                return $this->redirectToRoute('taxi_legion_homepage');
            }


            $tmp = $this->render('TaxiLegionBundle:Admin:index.html.twig', [
                'form_config' => $form->createView()
            ]);
        }

        return $tmp;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * страница со списком пользователей
     */
    public function usersAction()
    {
        $userManager = $this->container->get('taxi.user_manager');
        $users = $userManager->findUsers('ROLE_MANAGER');

        return $this->render('TaxiLegionBundle:Admin:users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * создание нового пользователя
     */
    public function createuserAction()
    {
        $user = new TaxiUser();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, [
                'label' => 'Логин', 'required' => false, 'attr' => [
                    'placeholder' => 'Логин'
                ]
            ])
            ->add('usernameCanonical', TextType::class, [
                'label' => 'ФИО', 'required' => false, 'constraints' => [
                    new NotBlank([
                        'message' => "Значение не должно быть пустым."
                    ])
                ], 'attr' => ['placeholder' => 'ФИО']
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль', 'required' => false, 'attr' => [
                    'placeholder' => 'Пароль'
                ]
            ])
            ->add('save', SubmitType::class, [
                    'label' => 'Добавить', 'attr' =>
                        ['class' => 'btn-primary']
                ]
            )
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userManager = $this->container->get('fos_user.user_manager');
            $newUser = $userManager->createUser();
            $newUser->setUsername($request->get('form')['username']);
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($newUser);
            $password = $encoder->encodePassword($request->get('form')['password'], $newUser->getSalt());
            $newUser->setPassword($password);
            $newUser->setEmail($request->get('form')['usernameCanonical']);
            $newUser->addRole("ROLE_MANAGER");
            $newUser->setEnabled(true);
            $em->persist($newUser);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_users');
        }

        return $this->render('TaxiLegionBundle:Admin:create_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * редактирование пользователя
     */
    public function usereditAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserBy(array('id' => $id));

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, [
                'label' => 'Новый логин', 'required' => false, 'attr' => [
                    'placeholder' => 'Новый логин'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Новый пароль', 'required' => false, 'attr' => [
                    'placeholder' => 'Новый пароль'
                ]
            ])
            ->add('save', SubmitType::class, [
                    'label' => 'Сохранить', 'attr' =>
                        ['class' => 'btn-primary']
                ]
            )
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUsername($request->get('form')['username']);
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $password = $encoder->encodePassword($request->get('form')['password'], $user->getSalt());
            $user->setPassword($password);

            $userManager->updateUser($user, true);

            return $this->redirectToRoute('taxi_legion_users');
        }

        //print_r($user->getUsername());

        return $this->render('TaxiLegionBundle:Admin:useredit.html.twig', [
            'id'   => $id,
            'name' => $user->getEmail(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * удаление пользователя
     */
    function userdeleteAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user        = $userManager->findUserBy(array('id' => $id));

        $userManager->deleteUser($user);

        return $this->redirectToRoute('taxi_legion_users');
    }

    /**
     * страница журналов
     */
    public function logbookAction()
    {
        return $this->render('TaxiLegionBundle:Admin:logbook.html.twig');
    }

    /**
     * страница тарифов
     */
    public function tariffsAction()
    {
        $tariffs = $this->getDoctrine()
            ->getRepository('TaxiLegionBundle:Tariffs')
            ->findAll();

        return $this->render('TaxiLegionBundle:Admin:tariffs.html.twig', [
            'tariffs' => $tariffs,
        ]);
    }

    /**
     * создание тарифа
     */
    function tariffcreateAction(Request $request)
    {
        $tariffs    = new TaxiTariffs();

        $form = $this->createForm(TariffForm::class, $tariffs);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tariffs);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_tariffs');
        }

        return $this->render('TaxiLegionBundle:Admin:tariffcreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * редактирование тарифа
     */
    function tariffeditAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $tariff = $em->getRepository('TaxiLegionBundle:Tariffs')->find($id);

        $form = $this->createForm(TariffForm::class, $tariff);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($tariff);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_tariffs');
        }

        return $this->render('TaxiLegionBundle:Admin:tariff_edit.html.twig', [
            'id'   => $id,
            'name' => $tariff->getName(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * удаление тарифа
     */
    public function tariffdeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tariff = $em->getRepository('TaxiLegionBundle:Tariffs')->find($id);

        $em->remove($tariff);
        $em->flush();

        return $this->redirectToRoute('taxi_legion_tariffs');
    }

    /**
     * страница водителей
     */
    public function driversAction()
    {
        $drivers = $this->getDoctrine()
            ->getRepository('TaxiLegionBundle:Drivers')
            ->findAll();

        return $this->render('TaxiLegionBundle:Admin:drivers.html.twig', [
            'drivers' => $drivers
        ]);
    }

    /**
     * создание водителя
     */
    function driver_createAction(Request $request)
    {
        $drivers    = new TaxiDrivers();

        $form = $this->createForm(DriversForm::class, $drivers);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $drivers->setCreateDate(new \DateTime('now'));
            $em->persist($drivers);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_drivers');
        }

        return $this->render('TaxiLegionBundle:Admin:driver_create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * редактирование водителя
     */
    function driver_editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $drivers = $em->getRepository('TaxiLegionBundle:Drivers')->find($id);

        $form = $this->createForm(DriversForm::class, $drivers);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($drivers);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_drivers');
        }

        return $this->render('TaxiLegionBundle:Admin:driver_edit.html.twig', [
            'id'   => $id,
            'name' => $drivers->getName(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * удаление водителя
     */
    public function driver_deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $driver = $em->getRepository('TaxiLegionBundle:Drivers')->find($id);

        $em->remove($driver);
        $em->flush();

        return $this->redirectToRoute('taxi_legion_drivers');
    }

    /**
     * типы заказов
     */
    public function type_orderAction()
    {
        $typeOrder = $this->getDoctrine()
            ->getRepository('TaxiLegionBundle:TypeOrder')
            ->findAll();

        return $this->render('TaxiLegionBundle:Admin:type_order.html.twig', [
            'type' => $typeOrder
        ]);
    }

    /**
     * создание типа заказа
     */
    public function type_order_createAction(Request $request)
    {
        $type    = new TypeOrder();

        $form = $this->createForm(TypeOrdersForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_type_order');
        }

        return $this->render('TaxiLegionBundle:Admin:type_order_create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * редактирование типа заказа
     */
    public function type_order_editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $type = $em->getRepository('TaxiLegionBundle:TypeOrder')->find($id);

        $form = $this->createForm(TypeOrdersForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($type);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_type_order');
        }

        return $this->render('TaxiLegionBundle:Admin:type_order_edit.html.twig', [
            'id'   => $id,
            'name' => $type->getName(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * удаление типа
     */
    public function type_order_deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('TaxiLegionBundle:TypeOrder')->find($id);

        $em->remove($type);
        $em->flush();

        return $this->redirectToRoute('taxi_legion_type_order');
    }

    /**
     * территориальные зоны
     */
    public function areaAction()
    {
        $areaOrder = $this->getDoctrine()
            ->getRepository('TaxiLegionBundle:AreaOrder')
            ->findAll();

        return $this->render('TaxiLegionBundle:Admin:area_order.html.twig', [
            'area' => $areaOrder
        ]);
    }

    /**
     * создание территориальной зоны
     */
    public function area_createAction(Request $request)
    {
        $area = new AreaOrder();

        $form = $this->createForm(AreaOrdersForm::class, $area);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($area);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_area');
        }

        return $this->render('TaxiLegionBundle:Admin:area_create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * редактирование территориальной зоны
     */
    public function area_editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $area = $em->getRepository('TaxiLegionBundle:AreaOrder')->find($id);

        $form = $this->createForm(AreaOrdersForm::class, $area);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($area);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_area');
        }

        return $this->render('TaxiLegionBundle:Admin:area_edit.html.twig', [
            'id'   => $id,
            'name' => $area->getName(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * удаление территориальной зоны
     */
    public function area_deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $area = $em->getRepository('TaxiLegionBundle:AreaOrder')->find($id);

        $em->remove($area);
        $em->flush();

        return $this->redirectToRoute('taxi_legion_area');
    }

    /**
     * скидки
     */
    public function discountAction()
    {
        $discount = $this->getDoctrine()->getManager()->getRepository('TaxiLegionBundle:Discount');
        $result = $discount->createQueryBuilder('d')
            ->select('d.id id, d.name name, d.travel travel, d.discount discount, a.name abonent, a.phone phone')
            ->leftJoin('TaxiLegionBundle:Abonents', 'a', 'WITH', 'd.abonent = a.id')
            ->getQuery();

        return $this->render('TaxiLegionBundle:Admin:discount.html.twig', [
            'discount' => $result->getResult()
        ]);
    }

    /**
     * создание скидки
     */
    public function discount_createAction(Request $request)
    {
        $discount = new Discount();

        $form = $this->createForm(DiscountForm::class, $discount);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($form->get('abonent')->getData()) {
                $discount->setAbonent($form->get('abonent')->getData()->getId());
            }

            $em->persist($discount);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_discount');
        }

        return $this->render('TaxiLegionBundle:Admin:discount_create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * редактирование скидки
     */
    public function discount_editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $discount = $em->getRepository('TaxiLegionBundle:Discount')->find($id);

        $form = $this->createForm(DiscountForm::class, $discount);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('abonent')->getData()) {
                $discount->setAbonent($form->get('abonent')->getData()->getId());
            }

            $em->persist($discount);
            $em->flush();
            return $this->redirectToRoute('taxi_legion_discount');
        }

        return $this->render('TaxiLegionBundle:Admin:discount_edit.html.twig', [
            'id'   => $id,
            'name' => $discount->getName(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * удаление скидки
     */
    public function discount_deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $discount = $em->getRepository('TaxiLegionBundle:Discount')->find($id);

        $em->remove($discount);
        $em->flush();

        return $this->redirectToRoute('taxi_legion_discount');
    }

}
