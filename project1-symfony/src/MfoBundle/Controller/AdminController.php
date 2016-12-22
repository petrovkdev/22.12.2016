<?php
namespace MfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use MfoBundle\Entity\SiteSettings;
use MfoBundle\Entity\User;

class AdminController extends CoreController
{
    /***
     * Настройки сайта
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function siteAction(Request $request)
    {
        $site = new SiteSettings();
        $em = $this->getDoctrine()->getManager();
        $siteSettings = $em->getRepository('MfoBundle:SiteSettings')->find('site');

        //$mfo = $this->container->getParameter('mfo');



        $phone = unserialize($siteSettings->getPhone());
        $robots = $siteSettings->getRobots();
        $maintenance = $siteSettings->getMaintenance();
        $logo = $siteSettings->getLogo();
        $favicon = $siteSettings->getFavicon();


        $form = $this->createFormBuilder($site)
            ->add('title', TextType::class, [
                'label' => 'Название сайта', 'attr' => [
                    'placeholder' => 'Название сайта',
                    'value' => $siteSettings->getTitle()
                ]
            ])
            ->add('slogan', TextType::class, [
                'label' => 'Слоган', 'attr' => [
                    'placeholder' => 'Слоган',
                    'value' => $siteSettings->getSlogan()
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Описание',
                ],
                'data' => $siteSettings->getDescription()
            ])
            ->add('keywords', TextareaType::class, [
                'label' => 'Ключевые слова (указывать через запятую)',
                'required' => false,
                'data' => $siteSettings->getKeywords(),
                'attr' => [
                    'placeholder' => 'Ключевые слова',
                ]
            ])
            ->add('robots', CheckboxType::class, [
                'label' => 'Не индексировать сайт',
                'required' => false,
                'attr' => [
                    'checked' => $robots
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Адрес',
                'attr' => [
                    'placeholder' => 'Адрес',
                    'value' => $siteSettings->getAddress()
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон',
            ])
            ->add('logo', FileType::class, [
                'label' => 'Логотип (в формате: png, jpg, jpeg, gif)',
                'attr' => [
                    'class' => 'logotip'
                ]
            ])
            ->add('favicon', FileType::class, [
                'label' => 'Иконка для вкладки в браузере (в формате: png, ico)',
                'attr' => [
                    'class' => 'favicon'
                ]
            ])
            ->add('maintenance', CheckboxType::class, [
                'label' => 'Перевести в режим обслуживания',
                'required' => false,
                'attr' => [
                    'checked' => $maintenance
                ]
            ])
            ->add('save', SubmitType::class)
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            switch ($request->get('action')) {
                case 'uploadLogo':
                    $extension = $form['logo']->getData()->guessExtension();

                    $result = new Response(json_encode(['error' => 'Файл не соответсвует формату, должно быть - png, jpg, jpeg, gif.']));

                    if (preg_match('/png|jpg|jpeg|gif/', $extension)) {
                        $form['logo']->getData()->move('bundles/mfo/tmp/logo', 'logo.' . $extension);

                        $view = $this->renderView('MfoBundle:admin/ajax:image_logo.html.twig', [
                            'logo_image' => 'logo.' . $extension
                        ]);

                        $siteSettings->setLogo('/bundles/mfo/tmp/logo/logo.' . $extension);

                        $em->persist($siteSettings);
                        $em->flush();

                        $result = new Response(json_encode(['error' => false, 'view' => $view]));
                    }

                    break;

                case 'changeLogo':
                    $view = $this->renderView('MfoBundle:admin/ajax:input_file_logo.html.twig', [
                        'form_site' => $form->createView(),
                    ]);
                    $result = new Response(json_encode(['view' => $view]));
                    break;

                case 'uploadFavicon':
                    $extension = $form['favicon']->getData()->guessExtension();

                    $result = new Response(json_encode(['error' => 'Файл не соответсвует формату, должно быть - png, ico.']));

                    if (preg_match('/png|ico/', $extension)) {
                        $form['favicon']->getData()->move('bundles/mfo/tmp/favicon', 'favicon.' . $extension);

                        $view = $this->renderView('MfoBundle:admin/ajax:image_favicon.html.twig', [
                            'favicon_image' => 'favicon.' . $extension
                        ]);

                        $siteSettings->setFavicon('/bundles/mfo/tmp/favicon/favicon.' . $extension);

                        $em->persist($siteSettings);
                        $em->flush();

                        $result = new Response(json_encode(['error' => false, 'view' => $view]));
                    }

                    break;

                case 'changeFavicon':
                    $view = $this->renderView('MfoBundle:admin/ajax:input_file_favicon.html.twig', [
                        'form_site' => $form->createView(),
                    ]);
                    $result = new Response(json_encode(['view' => $view]));
                    break;
            }
            return $result;
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $siteSettings->setTitle($request->get('form')['title']);
            $siteSettings->setSlogan($request->get('form')['slogan']);
            $siteSettings->setAddress($request->get('form')['address']);
            if (isset($request->get('form')['logo'])) {
                $siteSettings->setLogo($request->get('form')['logo']);
            }

            if (isset($request->get('form')['favicon'])) {
                $siteSettings->setFavicon($request->get('form')['favicon']);
            }


            $siteSettings->setPhone(serialize($request->get('form')['phone']));

            if (isset($request->get('form')['robots'])) {
                $siteSettings->setRobots(true);
            } else {
                $siteSettings->setRobots(false);
            }

            if (isset($request->get('form')['maintenance'])) {
                $siteSettings->setMaintenance(true);
            } else {
                $siteSettings->setMaintenance(false);
            }

            $siteSettings->setDescription($request->get('form')['description']);
            $siteSettings->setKeywords($request->get('form')['keywords']);

            $em->persist($siteSettings);
            $em->flush();

            return $this->redirectToRoute('admin_mfo_site');
        }

        return $this->render('MfoBundle:admin:site.html.twig', [
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'form_site' => $form->createView(),
            'phone' => $phone,
            'logo' => $logo,
            'favicon' => $favicon
        ]);
    }

    /***
     * редактирование пользователя
     */
    function usereditAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('MfoBundle:User')->findOneBy(['id' => $id]);

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, [
                'label' => 'Логин',
                'attr' => [
                    'placeholder' => 'Логин'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'attr' => [
                    'placeholder' => 'Пароль'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Электронная почта',
                'attr' => [
                    'placeholder' => 'Электронная почта',
                ]
            ])
            ->add('save', SubmitType::class)
            ->getForm();

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

        return $this->render('MfoBundle:admin:user_edit.html.twig', [
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'form_edit_user' => $form->createView(),
        ]);
    }


    /***
     * Конфигурация калькулятора
     */
    function calculator_configyrationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $calcConfig = $em->getRepository('MfoBundle:CalcConfig')->find('calculator');

        $form = $this->createFormBuilder($calcConfig)
            ->add('percent', NumberType::class, [
                'label' => 'Годовая процентная ставка', 'attr' => [
                    'placeholder' => 'Годовая процентная ставка',
                ]
            ])
            ->add('max_summ', NumberType::class, [
                'label' => 'Максимальная сумма кредита',
                'attr' => [
                    'placeholder' => 'Максимальная сумма кредита',
                ]
            ])
            ->add('max_time', NumberType::class, [
                'label' => 'Максимальный срок кредита',
                'attr' => [
                    'placeholder' => 'Максимальный срок кредита',
                ]
            ])
            ->add('save', SubmitType::class)
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($calcConfig);
            $em->flush();

            return $this->redirectToRoute('admin_mfo_calculator');
        }

        return $this->render('MfoBundle:admin:calculator_configyration.html.twig', [
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'form_calc' => $form->createView(),
        ]);
    }

    /***
     * ajax
     */
    function ajaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            switch ($request->get('action')) {

            }

            return $result;
        }
    }

}