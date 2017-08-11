<?php

namespace KvintBundle\Controller;

use KvintBundle\Datatables\GroupTovarDatatable;
use KvintBundle\Form\GroupTovarListType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupTovarController extends KvintFormsController
{
    protected $entity_name = 'kvint_spr_grouptov';
    /**
     * @Route("/grouptov/{grp}", options={"expose"=true}, name = "kvint_grouptov")
     * @Template()
     */
    public function groupTovarListAction(Request $request, $grp = null)
    {
        $form = $this->createForm(GroupTovarListType::class, null,
            [
                'em' => $this->getDoctrine()->getManager('kvint'),
                'grp' => $grp,
            ]
        );
        $form->handleRequest($request);
        $filter = null;
        if (!is_null($grp)) {
            $element = $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:GroupTovar')->find($grp);
            if (!is_null($element)) {
                $filter = [
                    ['field' => 'grouptovar.gname', 'name' => 'gname', 'value' => $element->getGname()]
                ];
            }
        }
        return $this->listAction($request, GroupTovarDatatable::class,
            [
                'errTxt' => "Client",
                'filterForm' => $form->createView(),
                'filter' => $filter,
//                'order' => [
//                    ['field' => 'grouptovar.gname', 'type' => 'asc'],
//                    ['field' => 'grouptovar.gname2', 'type' => 'asc'],
//                ]
            ]
        );
    }
}
