<?php

namespace Landing\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Landing\PageBundle\Forms\CreditCalculatorForm;
use Landing\PageBundle\Calculator\CalculatorCredit as Credit;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $siteSettings = $em->getRepository('MfoBundle:SiteSettings')->find('site');

        if ($siteSettings->getMaintenance()) {
            return $this->render('LandingPageBundle:Default:maintenance.html.twig', [
                'favicon_path' => $siteSettings->getFavicon(),
                'title' => $siteSettings->getTitle(),
            ]);
        }
        else {

            /**
             * calculator
             */
            $calcConf = $em->getRepository('MfoBundle:CalcConfig')->find('calculator');

            $max_time = $calcConf->getMaxTime();

            for ($i = 1; $i <= $max_time; $i++) {
                $arrTime[$i] = $i;
            }

            $creditCalcForm = new CreditCalculatorForm();

            $maxSum = $calcConf->getMaxSumm();

            $calcForm = $this->createForm($creditCalcForm, [
                'arrTime' => $arrTime,
                'maxSum' => $calcConf->getMaxSumm()
            ]);

            /**
             * get news
             */
            $query = $em->getRepository('MfoBundle:News')->findBy([],['date' => 'desc', 'id' => 'desc']);
             
            $paginator  = $this->get('knp_paginator');
            $news = $paginator->paginate($query, 1, 10);
            
            /**
             * get services
             */
            $services = $em->getRepository('MfoBundle:Services')->findBy([],['seq_number' => 'asc']);

            /**
             * microfinance
             */
            $ip = $em->getRepository('MfoBundle:Microfinance')->findBy(['category' => 0],['id' => 'asc']);
            $ul = $em->getRepository('MfoBundle:Microfinance')->findBy(['category' => 1],['id' => 'asc']);

            /**
             * information
             */
            $info = $em->getRepository('MfoBundle:Information')->findBy([],['id' => 'asc']);

            /**
             * staff
             */
            $staff = $em->getRepository('MfoBundle:Staff')->findBy([],['seq_number' => 'asc']);

            /**
             * address
             */
            $addresses = $em->getRepository('MfoBundle:Address')->findBy([],['id' => 'asc']);

            return $this->render('LandingPageBundle:Default:index.html.twig',[
                'favicon_path' => $siteSettings->getFavicon(),
                'logo_path'    => $siteSettings->getLogo(),
                'title'        => $siteSettings->getTitle(),
                'slogan'       => $siteSettings->getSlogan(),
                'description'  => $siteSettings->getDescription(),
                'keywords'     => $siteSettings->getKeywords(),
                'robots'       => $siteSettings->getRobots(),
                'address'      => $siteSettings->getAddress(),
                'phones'       => unserialize($siteSettings->getPhone()),
                'percent'      => $calcConf->getPercent(),
                'max_summ'     => $maxSum,
                'max_time'     => $max_time,
                'form_calc'    => $calcForm->createView(),
                'news'         => $news,
                'services'     => $services,
                'ip'           => $ip,
                'ul'           => $ul,
                'info'         => $info,
                'staff'        => $staff,
                'addresses'      => $addresses
            ]);
        }


    }

    /***
     * ajax
     */
    function ajaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            
            switch ($request->get('action')) {
                case 'calculator':                    

                    $creditCalcForm = new CreditCalculatorForm();

                    $calcConf = $em->getRepository('MfoBundle:CalcConfig')->find('calculator');
                    $siteSettings = $em->getRepository('MfoBundle:SiteSettings')->find('site');

                    $max_time = $calcConf->getMaxTime();

                    for ($i = 1; $i <= $max_time; $i++) {
                        $arrTime[$i] = $i;
                    }

                    $calcForm = $this->createForm($creditCalcForm, [
                        'arrTime' => $arrTime,
                        'maxSum' => $calcConf->getMaxSumm()
                    ]);

                    $calcForm->handleRequest($request);

                    if ($calcForm->isSubmitted() && $calcForm->isValid()) {

                        $sum     = $calcForm['sum']->getData();
                        $percent = $calcConf->getPercent();
                        $time    = $calcForm['time']->getData();
                        $date    = $calcForm['date']->getData();

                        $credit = new Credit($sum, $percent, $time, $date);

                        $credit_table = $credit->getCalculation();

                        $arr_full_sum_percent = [];
                        $arr_full_sum_credit  = [];


                        foreach ($credit_table->result as $k => $v) {
                            array_push($arr_full_sum_percent, $v['percent_pay']);
                            array_push($arr_full_sum_credit, $v['debd']);
                        }
                        $full_sum_percent = array_sum($arr_full_sum_percent);
                        $full_sum_credit  = array_sum($arr_full_sum_credit);
                        $sum_amount  = $full_sum_percent + $full_sum_credit;

                        return new JsonResponse([
                            'error' => false,
                            'view'  => $this->renderView('LandingPageBundle:Default/Modal:modal.html.twig', [
                                'size_class' => ' modal-lg',
                                'content'    => $this->renderView('LandingPageBundle:Default:credit_table.html.twig',[
                                    'credit_sum'       => $credit->getSum(),
                                    'credit_percent'   => $credit->getPercent(),
                                    'credit_time'      => $credit->getTime(),
                                    'sum_month'        => $credit->getSumMonth(),
                                    'month'            => $credit->getMonth(),
                                    'one_month_pay'    => $credit->getOneMonthPay(),
                                    'calculation'      => $credit_table->result,
                                    'amount'           => $sum_amount,
                                    'full_sum_percent' => $full_sum_percent,
                                    'full_sum_credit'  => $full_sum_credit,
                                    'logo_path'        => $siteSettings->getLogo(),
                                    'slogan'           => $siteSettings->getSlogan(),

                                ])
                            ])
                        ]);
                    }
                    else{
                        return new JsonResponse([
                            'error' => true,
                            'view'  => $this->renderView('LandingPageBundle:Default/Calculator:calculator.html.twig',[
                                'form_calc' => $calcForm->createView()
                            ])
                        ]);
                    }
                    break;

                case 'news':

                    $new = $em->getRepository('MfoBundle:News')->find($request->get('nid'));

                    return new JsonResponse([
                        'view' => $this->renderView('LandingPageBundle:Default/Modal:modal.html.twig', [
                            'size_class' => false,
                            'content'    => $this->renderView('LandingPageBundle:Default:news.html.twig',[
                                'content' => $new->getContent(),
                                'title'   => $new->getTitle(),
                            ])
                        ])
                    ]);

                    break;

                case 'services':

                    $data    = $em->getRepository('MfoBundle:Services')->find($request->get('nid'));
                    
                    $gallery_name = null;
                    $gallery = null;
                    
                    if($data->getGallery() != 0){
                        $gallery_name = $em->getRepository('ApplicationSonataMediaBundle:Gallery')->find($data->getGallery())->getName();
                        $gallery = $em->getRepository('ApplicationSonataMediaBundle:GalleryHasMedia')
                          ->createQueryBuilder('g')
                          ->select('m.id media, m.description')
                          ->leftJoin('ApplicationSonataMediaBundle:Media', 'm', 'WITH', 'm.id = g.media')
                          ->where('g.gallery = :gid')
                          ->orderBy('g.id', 'ASC')
                          ->setParameter('gid', $data->getGallery())
                          ->getQuery()
                          ->getResult();
                    }

                    return new JsonResponse([
                        'view' => $this->renderView('LandingPageBundle:Default/Modal:modal.html.twig', [
                            'size_class' => false,
                            'content'    => $this->renderView('LandingPageBundle:Default:service.html.twig',[
                                'content'  => $data->getContent(),
                                'media_id' => $data->getMediaId(),
                                'title'    => $data->getName(),
                                'gallery'  => $gallery,
                                'gallery_name' => $gallery_name
                            ])
                        ])
                    ]);

                    break;

                case 'info':

                    $data = $em->getRepository('MfoBundle:Information')->find($request->get('nid'));

                    return new JsonResponse([
                        'view' => $this->renderView('LandingPageBundle:Default/Modal:modal.html.twig', [
                            'size_class' => ' modal-lg',
                            'content'    => $this->renderView('LandingPageBundle:Default:info.html.twig',[
                                'body'  => $data->getBody(),
                                'title' => $data->getTitle(),
                            ])
                        ])
                    ]);

                    break;
                    
                case 'news_page':
                  $offset = ($request->get('page') - 1) * 10;
                  $data = $em->getRepository('MfoBundle:News')->findBy([],['date' => 'desc', 'id' => 'desc'],10,$offset);
                  
                  return new JsonResponse([
                        'view' => $this->renderView('LandingPageBundle:Default/Ajax:news_ajax.html.twig', [
                                'news'  => $data,
                        ])
                    ]);
                  break;
            }


        }
    }
}
