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
            return $responseService->getResponse((isset($options['grd_total'])) ? $options['grd_total'] : true);
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

            $this->flushWithBeforeAfter($em, $element, $options);

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

            $this->flushWithBeforeAfter($em, $element, $options);

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

    private function handleBeforePersist($em, $element, $options) {
        if (isset($options['entity_name']) && method_exists($element, 'beforePersist')) {
            $element->beforePersist();
        }
    }

    private function handleBeforeUpdate($em, $element, $options) {
        $repositoryRezult = [];
        if (isset($options['entity_name']) && method_exists($em->getRepository($options['entity_name']), 'processChanges')) {
            $repositoryRezult = $em->getRepository($options['entity_name'])->processChanges($element, [
                'type' => 'update',
                'userName' => $this->getUser()->getUsername(),
                'comp_name' => isset($options['comp_name']) ? $options['comp_name'] : '',
            ]);
        }
        $objectRezult = [];
        if (isset($options['entity_name']) && method_exists($element, 'beforeUpdate')) {
            $objectRezult = $element->beforeUpdate();
        }
        return [
            'from_rep' => $repositoryRezult,
            'from_obj' => $objectRezult,
        ];
    }

    private function handleAfterUpdate($em, $element, $options, $beforeRezult) {
        if (isset($options['entity_name']) && method_exists($em->getRepository($options['entity_name']), 'processChangesAfter')) {
            $em->getRepository($options['entity_name'])->processChangesAfter($element, [
                'type' => 'update',
                'userName' => $this->getUser()->getUsername(),
                'comp_name' => isset($options['comp_name']) ? $options['comp_name'] : '',
            ], $beforeRezult);
        }
        if (isset($options['entity_name']) && method_exists($element, 'afterUpdate')) {
            $element->afterUpdate();
        }
    }

    private function flushWithBeforeAfter($em, $element, $options) {
        $this->handleBeforePersist($em, $element, $options);
        $em->persist($element);
        $rezBefore = $this->handleBeforeUpdate($em, $element, $options);
        $em->flush();
        $this->handleAfterUpdate($em, $element, $options, $rezBefore);
    }
}