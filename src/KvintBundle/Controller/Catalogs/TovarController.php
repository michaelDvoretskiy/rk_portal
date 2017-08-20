<?php

namespace KvintBundle\Controller\Catalogs;

use AppBundle\Utils\MyHelper;
use KvintBundle\Controller\KvintFormsController;
use KvintBundle\Datatables\TovarDatatable;
use KvintBundle\Entity\Tovar;
use KvintBundle\Form\GroupTovarListType;
use KvintBundle\Form\TovarFilterType;
use KvintBundle\Form\TovarType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
}
