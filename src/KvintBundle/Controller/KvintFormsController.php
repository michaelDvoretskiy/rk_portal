<?php

namespace KvintBundle\Controller;

use AppBundle\Utils\EntityRightsChecker;
use KvintBundle\Entity\Klient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class KvintFormsController extends Controller
{
    use EntityRightsChecker;
    protected $entity_name;

    protected function listAction(Request $request, $dataTableType, array $options)
    {
        if (!$this->hasRight('list')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => $options['errTxt'] . " dictionary. Access deny"]);
        }
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create($dataTableType);
        $datatable->rights = $this->getRights();
        if (isset($options['return_parameters'])) {
            $datatable->returnParameters = $options['return_parameters'];
        }
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);

            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();

            if (isset($options['filter']) && (!is_null($options['filter']))) {
                $qb = $datatableQueryBuilder->getQb();
                foreach($options['filter'] as $filter) {
                    if (isset($filter['value2'])) {
                        $qb->andWhere(
                            $qb->expr()->between(
                                $filter['field'],
                                ":" . $filter['name'],
                                ':' . $filter['name2']
                            )
                        );
                        $qb->setParameter($filter['name'], $filter['value']);
                        $qb->setParameter($filter['name2'], $filter['value2']);
                    } else {
                        $qb->andWhere($filter['field'] . ' = :' . $filter['name']);
                        $qb->setParameter($filter['name'], $filter['value']);
                    }
                }
            }
            return $responseService->getResponse();
        }
        if (!isset($options['filterForm'])) {
            $options['filterForm'] = null;
        }
        return [
            'datatable' => $datatable,
            'is_add_btn' => $datatable->rights['add'],
            'filterForm' => $options['filterForm'],
            'options' => $options,
        ];
    }

    protected function showAction(Request $request, $element, array $options) {
        if (!$this->hasRight('view')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "View " . $options['errTxt'] . " dictinary element. Access deny"]);
        }

        $form_type_options = [];
        if (isset($options['form_type_options'])) {
            $form_type_options = $options['form_type_options'];
        }
        $form = $this->createForm($options['form_type'], $element, $form_type_options);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (isset($options['return_parameters'])) {
                return $this->redirectToRoute($options['route_return'], $options['return_parameters']);
            }
            return $this->redirectToRoute($options['route_return']);
        }

        $other_options = null;
        if (isset($options['other_options'])) {
            $other_options = $options['other_options'];
        }

        $additional_datatables = null;
        if (isset($options['additional_datatables'])) {
            $additional_datatables = [];
            foreach($options['additional_datatables'] as $additional_datatable_options) {
                $dt = $this->get('sg_datatables.factory')->create($additional_datatable_options['data_table_type']);
                $rightEdit = $this->hasRight('edit');
                $dt->rights = [
                    'view' => false,
                    'add' => $rightEdit,
                    'edit' => $rightEdit,
                    'delete' => $rightEdit,
                ];
                if (isset($additional_datatable_options['return_parameters'])) {
                    $dt->returnParameters = $additional_datatable_options['return_parameters'];
                }
                $dt->ajaxUrl = $additional_datatable_options['ajax_url'];
                $dt->buildDatatable();
                $additional_datatables[$additional_datatable_options['name']] = $dt;
            }
        }

        return $this->render($options['template'], [
            $options['form_name'] => $form->createView(),
            'title' => $options['titleTxt'],
            'type' => 'show',
            'other_options' => $other_options,
            'additional_datatables' => $additional_datatables,
        ]);
    }

    protected function editAction(Request $request, $element, array $options) {
        if (!$this->hasRight('edit')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "Edit " . $options['errTxt'] . " dictinary element. Access deny"]);
        }

        $form_type_options = [];
        if (isset($options['form_type_options'])) {
            $form_type_options = $options['form_type_options'];
        }
        $form = $this->createForm($options['form_type'], $element, $form_type_options);
//        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $element = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $em->persist($element);
            if (isset($options['entity_name']) && method_exists($em->getRepository($options['entity_name']), 'processChanges')) {
                $em->getRepository($options['entity_name'])->processChanges($element, [
                    'type' => 'update',
                    'userName' => $this->getUser()->getUsername(),
                ]);
            }
            if (isset($options['entity_name']) && method_exists($element, 'beforeUpdate')) {
                $element->beforeUpdate();
            }
            $em->flush();
            $this->addFlash('success', $options['errTxt'] . " updated!");
            if (isset($options['return_parameters'])) {
                return $this->redirectToRoute($options['route_return'], $options['return_parameters']);
            }
            return $this->redirectToRoute($options['route_return']);
        }

        $other_options = null;
        if (isset($options['other_options'])) {
            $other_options = $options['other_options'];
        }

        $additional_datatables = null;
        if (isset($options['additional_datatables'])) {
            $additional_datatables = [];
            foreach($options['additional_datatables'] as $additional_datatable_options) {
                $dt = $this->get('sg_datatables.factory')->create($additional_datatable_options['data_table_type']);
                $rightEdit = $this->hasRight('edit');
                $dt->rights = [
                    'view' => false,
                    'add' => $rightEdit,
                    'edit' => $rightEdit,
                    'delete' => $rightEdit,
                ];
                if (isset($additional_datatable_options['return_parameters'])) {
                    $dt->returnParameters = $additional_datatable_options['return_parameters'];
                }
                $dt->ajaxUrl = $additional_datatable_options['ajax_url'];
                $dt->buildDatatable();
                $additional_datatables[$additional_datatable_options['name']] = $dt;
            }
        }

        return $this->render($options['template'], [
            $options['form_name'] => $form->createView(),
            'title' => $options['titleTxt'],
            'type' => 'edit',
            'other_options' => $other_options,
            'additional_datatables' => $additional_datatables,
        ]);
    }

    protected function removeAction($element, array $options) {
        if (!$this->hasRight('delete')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "Delete " . $options['errTxt'] . " dictinary element. Access deny"]);
        }

        $em = $this->getDoctrine()->getManager("kvint");
        $em->remove($element);
        $em->flush();
        if (isset($options['return_parameters'])) {
            return $this->redirectToRoute($options['route_return'], $options['return_parameters']);
        }
        return $this->redirectToRoute($options['route_return']);
    }

    protected function addAction(Request $request, $element, array $options) {
        if (!$this->hasRight('add')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "Add " . $options['errTxt'] . " dictinary element. Access deny"]);
        }

        $form_type_options = [];
        if (isset($options['form_type_options'])) {
            $form_type_options = $options['form_type_options'];
        }
        $form = $this->createForm($options['form_type'], $element, $form_type_options);
        $form->remove('kod');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $element = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $element->setKod($em->getRepository($options['entity_name'])->generateKod());
            $em->persist($element);
            if (isset($options['entity_name']) && method_exists($em->getRepository($options['entity_name']), 'processChanges')) {
                $em->getRepository($options['entity_name'])->processChanges($element, [
                    'type' => 'insert',
                    'userName' => $this->getUser()->getUsername(),
                ]);
            }
            $em->flush();
            if (isset($options['return_parameters'])) {
                return $this->redirectToRoute($options['route_return'], $options['return_parameters']);
            }
            return $this->redirectToRoute($options['route_return']);
        }

        $other_options = null;
        if (isset($options['other_options'])) {
            $other_options = $options['other_options'];
        }

        return $this->render($options['template'], [
            $options['form_name'] => $form->createView(),
            'title' => $options['titleTxt'],
            'type' => 'new',
            'other_options' => $other_options,
        ]);
    }
}