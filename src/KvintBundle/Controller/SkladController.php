<?php

namespace KvintBundle\Controller;

use KvintBundle\Entity\Sklad;
use KvintBundle\Form\SkladType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use KvintBundle\Datatables\SkladDatatable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SkladController extends Controller
{
    /**
     * @Route("/sklad", name="kvint_sklad")
     * @Template()
     */
    public function skladListAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(SkladDatatable::class);
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
        ];
    }

    /**
     * @param Sklad $sklad
     *
     * @Route("/sklad/show/{id}", name = "kvint_sklad_show", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showSkladAction(Request $request, Sklad $sklad)
    {
        $form = $this->createForm(SkladType::class, $sklad);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('kvint_sklad');
        }

        return $this->render('@Kvint/Sklad/skladElement.html.twig', [
            'skladForm' => $form->createView(),
            'title' => ' склада ' . $sklad->getSname(),
            'type' => 'show',
        ]);
    }

    /**
     * @param Sklad $sklad
     *
     * @Route("/sklad/edit/{id}", name = "kvint_sklad_edit", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function editSkladAction(Request $request, Sklad $sklad) {
        $form = $this->createForm(SkladType::class, $sklad);
//        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sklad = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $em->persist($sklad);
            $em->flush();
            $this->addFlash('success', 'Sklad updated!');
            return $this->redirectToRoute('kvint_sklad');
        }

        return $this->render('@Kvint/Sklad/skladElement.html.twig', [
            'skladForm' => $form->createView(),
            'title' => ' склада ' . $sklad->getSname(),
            'type' => 'edit',
        ]);
    }

    /**
     * @param Sklad $sklad
     *
     * @Route("/sklad/remove/{id}", name = "kvint_sklad_remove", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function removeSkladAction(Request $request, Sklad $sklad) {
        $em = $this->getDoctrine()->getManager("kvint");
        $em->remove($sklad);
        $em->flush();
        return $this->redirectToRoute('kvint_sklad');
    }

    /**
     * @param Sklad $sklad
     *
     * @Route("/sklad/add", name = "kvint_sklad_add", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function addSkladAction(Request $request) {
        $sklad = new Sklad();
        $form = $this->createForm(SkladType::class, $sklad);
        $form->remove('kod');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sklad = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $sklad->setKod($em->getRepository("KvintBundle:Sklad")->generateKod());
            $em->persist($sklad);
            $em->flush();
            return $this->redirectToRoute('kvint_sklad');
        }
        return $this->render('@Kvint/Sklad/skladElement.html.twig', [
            'skladForm' => $form->createView(),
            'title' => ' склада',
            'type' => 'new',
        ]);
    }
}