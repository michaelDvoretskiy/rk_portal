<?php

namespace KvintBundle\Controller;

use KvintBundle\Datatables\EntDatatable;
use KvintBundle\Entity\Ent;
use KvintBundle\Form\EntType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EntController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/ent", name="kvint_ent")
     * @Template()
     */
    public function entListAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(EntDatatable::class);
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
     * @param Ent $ent
     *
     * @Route("/ent/show/{id}", name = "kvint_ent_show", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showEntAction(Request $request, Ent $ent)
    {
        $form = $this->createForm(EntType::class, $ent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('kvint_ent');
        }

        return $this->render('@Kvint/Ent/entElement.html.twig', [
            'entForm' => $form->createView(),
            'title' => ' организации ' . $ent->getName(),
            'type' => 'show',
        ]);
    }

    /**
     * @param Ent $ent
     *
     * @Route("/ent/edit/{id}", name = "kvint_ent_edit", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function editEntAction(Request $request, Ent $ent) {
        $form = $this->createForm(EntType::class, $ent);
//        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ent = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $em->persist($ent);
            $em->flush();
            $this->addFlash('success', 'Ent updated!');
            return $this->redirectToRoute('kvint_ent');
        }

        return $this->render('@Kvint/Ent/entElement.html.twig', [
            'entForm' => $form->createView(),
            'title' => ' организации ' . $ent->getName(),
            'type' => 'edit',
        ]);
    }

    /**
     * @param Ent $ent
     *
     * @Route("/ent/remove/{id}", name = "kvint_ent_remove", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function removeSkladAction(Request $request, Ent $ent) {
        $em = $this->getDoctrine()->getManager("kvint");
        $em->remove($ent);
        $em->flush();
        return $this->redirectToRoute('kvint_ent');
    }

    /**
     * @param Sklad $sklad
     *
     * @Route("/ent/add", name = "kvint_ent_add", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function addSkladAction(Request $request) {
        $ent = new Ent();
        $form = $this->createForm(EntType::class, $ent);
        $form->remove('kod');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ent = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $ent->setKod($em->getRepository("KvintBundle:Ent")->generateKod());
            $em->persist($ent);
            $em->flush();
            return $this->redirectToRoute('kvint_ent');
        }
        return $this->render('@Kvint/Ent/entElement.html.twig', [
            'entForm' => $form->createView(),
            'title' => ' организации',
            'type' => 'new',
        ]);
    }
}
