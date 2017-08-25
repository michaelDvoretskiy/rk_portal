<?php

namespace KvintBundle\Controller\Catalogs;

use AppBundle\Utils\MyHelper;
use KvintBundle\Controller\KvintFormsController;
use KvintBundle\Datatables\TovarDatatable;
use KvintBundle\Entity\KvintListedEntities;
use KvintBundle\Entity\ScanCode;
use KvintBundle\Entity\Tovar;
use KvintBundle\Form\ScanCodeType;
use KvintBundle\Form\TovarFilterType;
use KvintBundle\Form\TovarType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TovarController extends KvintFormsController
{
    protected $entity_name = 'kvint_spr_tovar';
    /**
     * @Route("/tovar/{grp}/{subgrp}", options={"expose"=true}, name = "kvint_tovar")
     * @Template()
     */
    public function tovarListAction(Request $request, $grp = null, $subgrp = null)
    {
        $form = $this->createForm(TovarFilterType::class, null,
            [
                'em' => $this->getDoctrine()->getManager('kvint'),
                'grp' => $grp,
                'subgrp' => $subgrp,
            ]
        );
        $form->handleRequest($request);
        $filter = null;
        if (!is_null($grp)) {
            $findgroup = $grp;
        }
        if (!is_null($subgrp)) {
            $findgroup = $subgrp;
        }
        if (isset($findgroup) && ($findgroup != 0)) {
            $filter = [
                ['field' => "IDENTITY(tovar.groupTovar)", 'name' => 'grouptovar', 'value' => $findgroup]
            ];
        }

        $options = [
            'errTxt' => "Tovar",
            'filterForm' => $form->createView(),
            'filter' => $filter,
        ];

        if (!is_null($grp) && ($grp != 0)) {
            $options['return_parameters']['ffo_grp'] = $grp;
        }
        if (!is_null($subgrp) && ($subgrp != 0)) {
            $options['return_parameters']['ffo_subgrp'] = $subgrp;
        }

        return $this->listAction($request, TovarDatatable::class, $options);
    }

    /**
     * @param Tovar $tovar
     *
     * @Route("/tov/show/{id}", name = "kvint_tovar_show", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showTovarAction(Request $request, Tovar $tovar)
    {
        return $this->showAction($request, $tovar,
            [
                'errTxt' => 'tovar',
                'form_type' => TovarType::class,
                'form_name' => 'tovarForm',
                'route_return' => 'kvint_tovar',
                'titleTxt' => ' товар ' . trim($tovar->getTname()),
                'template' =>  '@Kvint/Catalogs/Tovar/tovarElement.html.twig',
                'return_parameters' => MyHelper::getPrefixed('ffo', $request->query->all()),
                'other_options' => [
                    'remains' => $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:Tovar')->getRemains($tovar),
                    'id_scans' => $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:Tovar')->getDopScanCodes($tovar->getKod()),
                    'extra1name' => array_search(1, KvintListedEntities::Prices()),
                    'extra2name' => array_search(2, KvintListedEntities::Prices()),
                ],

            ]
        );
    }

    /**
     * @param Tovar $tovar
     *
     * @Route("/tov/edit/{id}", name = "kvint_tovar_edit", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function editTovarAction(Request $request, Tovar $tovar) {
        return $this->editAction($request, $tovar,
            [
                'errTxt' => 'tovar',
                'form_type' => TovarType::class,
                'form_name' => 'tovarForm',
                'route_return' => 'kvint_tovar',
                'titleTxt' => ' товар ' . trim($tovar->getTname()),
                'template' =>  '@Kvint/Catalogs/Tovar/tovarElement.html.twig',
                'return_parameters' => MyHelper::getPrefixed('ffo', $request->query->all()),
                'other_options' => [
                    'remains' => $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:Tovar')->getRemains($tovar),
                    'id_scans' => $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:Tovar')->getDopScanCodes($tovar->getKod()),
                    'extra1name' => array_search(1, KvintListedEntities::Prices()),
                    'extra2name' => array_search(2, KvintListedEntities::Prices()),
                ],
            ]
        );
    }

    /**
     * @param Tovar $tovar
     *
     * @Route("/tov/remove/{id}", name = "kvint_tovar_remove", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function removeGroupTovarAction(Request $request, Tovar $tovar) {
        return $this->removeAction($tovar,
            [
                'errTxt' => 'tovar',
                'route_return' => 'kvint_tovar',
                'return_parameters' => MyHelper::getPrefixed('ffo', $request->query->all()),
            ]
        );
    }

    /**
     * @Route("/tov/add", name = "kvint_tovar_add", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function addTovarAction(Request $request) {
        $params = MyHelper::getPrefixed('ffo', $request->query->all());
        $newTovar = new Tovar();
        $findgroup = 0;
        if (isset($params['grp'])) {
            $findgroup = $params['grp'];
        }
        if (isset($params['subgrp'])) {
            $findgroup = $params['subgrp'];
        }
        if ($findgroup != 0) {
            $parentGroup = $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:GroupTovar')->find($findgroup);
        }
        if (isset($parentGroup) && !is_null($parentGroup)) {
            $newTovar->setGroupTovar($parentGroup);
        }
        return $this->addAction($request, $newTovar,
            [
                'errTxt' => 'tovar',
                'form_type' => TovarType::class,
                'form_name' => 'tovarForm',
                'route_return' => 'kvint_tovar',
                'titleTxt' => ' товара ',
                'template' =>  '@Kvint/Catalogs/Tovar/tovarElement.html.twig',
                'entity_name' => 'KvintBundle:Tovar',
                'return_parameters' => $params,
            ]
        );
    }

    /**
     * @param $kod
     * @Route("/tov/dopscankod/{kod}", name = "kvint_tovar_dopscankod", options = {"expose" = true})
     * @return JsonResponse
     */
    public function getJSONscanCodesAction($kod) {
        if (!$this->hasRight('view')) {
            return new JsonResponse();
        }
        return new JsonResponse($this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:Tovar')->getDopScanCodes($kod));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */
    public function dopScanCodesFormAction($kodtov, $scanCode = null) {
        if (is_null($scanCode)) {
            $tovar = $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:Tovar')->find($kodtov);
            $scanCode = (new ScanCode())->setKodtov($tovar)->setIdScan('')->setQuantity(1);
        } else {
            $scanCode = $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:ScanCode')->find(['kodtov' => $kodtov, 'idScan' => $scanCode]);
        }
        $form = $this->createForm(ScanCodeType::class, $scanCode);
        return [
            'scanCodeForm' => $form->createView(),
            'type' => 'edit',
        ];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/tov/dopscankodadd", name = "kvint_tovar_dopscankod_add", options = {"expose" = true})
     * @return JsonResponse
     */
    public function dopScanCodesAddAction(Request $request) {
        if ($this->hasRight('edit')) {
            $kodtov = $request->request->get('kodtov');
            $id_scan = $request->request->get('id_scan');
            $quantity = $request->request->get('quantity');
            dump($kodtov);
            if (!is_null($kodtov) && !is_null($id_scan) && !is_null($quantity)) {
                $em = $this->getDoctrine()->getManager('kvint');
                $tovar = $em->getRepository('KvintBundle:Tovar')->find($kodtov);
                $scanCode = (new ScanCode())->setKodtov($tovar)->setIdScan($id_scan)->setQuantity($quantity);
                $em->persist($scanCode);
                $em->flush();
            }
        }
        return $this->getJSONscanCodesAction($kodtov);
    }
}