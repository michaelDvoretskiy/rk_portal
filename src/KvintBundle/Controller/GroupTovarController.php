<?php

namespace KvintBundle\Controller;

use AppBundle\Utils\MyHelper;
use KvintBundle\Datatables\GroupTovarDatatable;
use KvintBundle\Entity\GroupTovar;
use KvintBundle\Form\GroupTovarListType;
use KvintBundle\Form\GroupTovarType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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

        $options = [
            'errTxt' => "Client",
            'filterForm' => $form->createView(),
            'filter' => $filter,
            'add_path2' => 'kvint_grouptov_add2',
        ];

        if (!is_null($grp)) {
            $options['return_parameters']['ffo_grp'] = $grp;
        }

        return $this->listAction($request, GroupTovarDatatable::class, $options);
    }

    /**
     * @param GroupTovar $groupTov
     *
     * @Route("/grouptov/show/{id}", name = "kvint_grouptov_show", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showGroupTovarAction(Request $request, GroupTovar $groupTov)
    {
        $title = trim($groupTov->getGname2());
        if ($title == '') {
            $title = ' группа ' . trim($groupTov->getGname());
            $type2 = 'group';
        } else {
            $title = ' подгруппа ' . $title;
            $type2 = 'subgroup';
        }
        return $this->showAction($request, $groupTov,
            [
                'errTxt' => 'grouptovar',
                'form_type' => GroupTovarType::class,
                'form_name' => 'grouptovForm',
                'route_return' => 'kvint_grouptov',
                'titleTxt' => $title,
                'template' =>  '@Kvint/GroupTovar/groupTovarElement.html.twig',
                'return_parameters' => MyHelper::getPrefixed('ffo', $request->query->all()),
                'other_options' => ['grp_type' => $type2],
            ]
        );
    }

    /**
     * @param GroupTovar $groupTov
     *
     * @Route("/grouptov/edit/{id}", name = "kvint_grouptov_edit", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function editGroupTovarAction(Request $request, GroupTovar $groupTov) {
        $stuff = $this->getStuff($groupTov);

        return $this->editAction($request, $groupTov,
            [
                'errTxt' => 'grouptovar',
                'form_type' => GroupTovarType::class,
                'form_name' => 'grouptovForm',
                'route_return' => 'kvint_grouptov',
                'titleTxt' => $stuff['title'],
                'template' =>  '@Kvint/GroupTovar/groupTovarElement.html.twig',
                'return_parameters' => MyHelper::getPrefixed('ffo', $request->query->all()),
                'other_options' => ['grp_type' => $stuff['type2']],
            ]
        );
    }

    /**
     * @param GroupTovar $groupTov
     *
     * @Route("/grouptov/remove/{id}", name = "kvint_grouptov_remove", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function removeGroupTovarAction(Request $request, GroupTovar $groupTov) {
        return $this->removeAction($groupTov,
            [
                'errTxt' => 'client',
                'route_return' => 'kvint_grouptov',
                'return_parameters' => MyHelper::getPrefixed('ffo', $request->query->all()),
            ]
        );
    }

    /**
     * @Route("/grouptovar/add", name = "kvint_grouptov_add", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function addSubGroupTovarAction(Request $request) {
        $params = MyHelper::getPrefixed('ffo', $request->query->all());
        $parentGroup = $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:GroupTovar')->find($params['grp']);
        if (!is_null($parentGroup)) {
            return $this->addAction($request, (new GroupTovar())->setGname($parentGroup->getGname()),
                [
                    'errTxt' => 'grouptovar',
                    'form_type' => GroupTovarType::class,
                    'form_name' => 'grouptovForm',
                    'route_return' => 'kvint_grouptov',
                    'titleTxt' => ' подгруппы ',
                    'template' =>  '@Kvint/GroupTovar/groupTovarElement.html.twig',
                    'entity_name' => 'KvintBundle:GroupTovar',
                    'return_parameters' => $params,
                    'other_options' => ['grp_type' => 'subgroup'],
                ]
            );
        } else {
            return $this->redirectToRoute('kvint_grouptov', $params);
        }
    }

    /**
     * @Route("/grouptovar/add2", name = "kvint_grouptov_add2", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function addGroupTovarAction(Request $request) {
        return $this->addAction($request, new GroupTovar(),
            [
                'errTxt' => 'grouptovar',
                'form_type' => GroupTovarType::class,
                'form_name' => 'grouptovForm',
                'route_return' => 'kvint_grouptov',
                'titleTxt' => ' группы ',
                'template' =>  '@Kvint/GroupTovar/groupTovarElement.html.twig',
                'entity_name' => 'KvintBundle:GroupTovar',
                'other_options' => ['grp_type' => 'group'],
            ]
        );
    }

    private function getStuff(GroupTovar $groupTov) {
        $title = trim($groupTov->getGname2());
        if ($title == '') {
            $title = ' группа ' . trim($groupTov->getGname());
            $type2 = 'group';
        } else {
            $title = ' подгруппа ' . $title;
            $type2 = 'subgroup';
        }
        return [
            'title' => $title,
            'type2' => $type2,
        ];
    }
}