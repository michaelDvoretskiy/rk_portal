<?php

namespace KvintBundle\Controller;

use AppBundle\Utils\EntityRightsChecker;
use KvintBundle\Entity\Klient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);

            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();
            return $responseService->getResponse();
        }

        return [
            'datatable' => $datatable,
            'is_add_btn' => $datatable->rights['add'],
        ];
    }

    protected function showAction(Request $request, $element, array $options) {
        if (!$this->hasRight('view')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "View " . $options['errTxt'] . " dictinary element. Access deny"]);
        }

        $form = $this->createForm($options['form_type'], $element);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute($options['route_return']);
        }

        return $this->render($options['template'], [
            $options['form_name'] => $form->createView(),
            'title' => $options['titleTxt'],
            'type' => 'show',
        ]);
    }

    protected function editAction(Request $request, $element, array $options) {
        if (!$this->hasRight('edit')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "Edit " . $options['errTxt'] . " dictinary element. Access deny"]);
        }

        $form = $this->createForm($options['form_type'], $element);
//        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $element = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $em->persist($element);
            $em->flush();
            $this->addFlash('success', $options['errTxt'] . " updated!");
            return $this->redirectToRoute($options['route_return']);
        }

        return $this->render($options['template'], [
            $options['form_name'] => $form->createView(),
            'title' => $options['titleTxt'],
            'type' => 'edit',
        ]);
    }

    protected function removeAction($element, array $options) {
        if (!$this->hasRight('delete')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "Delete " . $options['errTxt'] . " dictinary element. Access deny"]);
        }

        $em = $this->getDoctrine()->getManager("kvint");
        $em->remove($element);
        $em->flush();
        return $this->redirectToRoute($options['route_return']);
    }

    protected function addAction(Request $request, $element, array $options) {
        if (!$this->hasRight('add')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => "Add " . $options['errTxt'] . " dictinary element. Access deny"]);
        }

        $form = $this->createForm($options['form_type'], $element);
        $form->remove('kod');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $element = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $element->setKod($em->getRepository($options['entity_name'])->generateKod());
            $em->persist($element);
            $em->flush();
            return $this->redirectToRoute($options['route_return']);
        }
        return $this->render($options['template'], [
            $options['form_name'] => $form->createView(),
            'title' => $options['titleTxt'],
            'type' => 'new',
        ]);
    }
}