<?php

namespace KvintBundle\Controller\Catalogs;

use KvintBundle\Controller\KvintFormsController;
use KvintBundle\Datatables\TovarDatatable;
use KvintBundle\Form\GroupTovarListType;
use KvintBundle\Form\TovarFilterType;
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
}
