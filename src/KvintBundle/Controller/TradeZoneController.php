<?php

namespace KvintBundle\Controller;

use AppBundle\Utils\EntityRightsChecker;
use KvintBundle\Datatables\TradeZoneDatatable;
use KvintBundle\Entity\TradeZone;
use KvintBundle\Form\TradeZoneType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TradeZoneController extends Controller
{
    use EntityRightsChecker;
    private $entity_name = 'kvint_spr_trade_zone';
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/trade_zone", name="kvint_trade_zone")
     * @Template()
     */
    public function tradezoneListAction(Request $request)
    {
        if (!$this->hasRight('list')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => 'Trade zone dictionary. Access deny']);
        }
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(TradeZoneDatatable::class);
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

    /**
     * @param TradeZone $zone
     *
     * @Route("/trade_zone/show/{id}", name = "kvint_trade_zone_show", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showTradezoneAction(Request $request, TradeZone $zone)
    {
        if (!$this->hasRight('view')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => 'View trade zone dictinary element. Access deny']);
        }
        $form = $this->createForm(TradeZoneType::class, $zone);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('kvint_trade_zone');
        }

        return $this->render('@Kvint/TradeZone/tradezoneElement.html.twig', [
            'zoneForm' => $form->createView(),
            'title' => ' торговой зоны ' . $zone->getName(),
            'type' => 'show',
        ]);
    }

    /**
     * @param TradeZone $zone
     *
     * @Route("/trade_zone/edit/{id}", name = "kvint_trade_zone_edit", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function editTradeZoneAction(Request $request, TradeZone $zone) {
        if (!$this->hasRight('edit')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => 'Edit trade zone dictinary element. Access deny']);
        }
        $form = $this->createForm(TradeZoneType::class, $zone);
//        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $zone = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $em->persist($zone);
            $em->flush();
            $this->addFlash('success', 'Zone updated!');
            return $this->redirectToRoute('kvint_trade_zone');
        }

        return $this->render('@Kvint/TradeZone/tradezoneElement.html.twig', [
            'zoneForm' => $form->createView(),
            'title' => ' торговой зоны ' . $zone->getName(),
            'type' => 'edit',
        ]);
    }

    /**
     * @param TradeZone $zone
     *
     * @Route("/trade_zone/remove/{id}", name = "kvint_trade_zone_remove", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function removeTradezoneAction(Request $request, TradeZone $zone) {
        if (!$this->hasRight('delete')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => 'Delete trade zone dictinary element. Access deny']);
        }

        $em = $this->getDoctrine()->getManager("kvint");
        $em->remove($zone);
        $em->flush();
        return $this->redirectToRoute('kvint_trade_zone');
    }

    /**
     * @Route("/trade_zone/add", name = "kvint_trade_zone_add", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function addTradezoneAction(Request $request) {
        if (!$this->hasRight('add')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => 'Add trade zone dictinary element. Access deny']);
        }
        $zone = new TradeZone();
        $form = $this->createForm(TradeZoneType::class, $zone);
        $form->remove('kod');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $zone = $form->getData();
            $em = $this->getDoctrine()->getManager("kvint");
            $zone->setKod($em->getRepository("KvintBundle:TradeZone")->generateKod());
            $em->persist($zone);
            $em->flush();
            return $this->redirectToRoute('kvint_trade_zone');
        }
        return $this->render('@Kvint/TradeZone/tradezoneElement.html.twig', [
            'zoneForm' => $form->createView(),
            'title' => ' тотрговой зоны',
            'type' => 'new',
        ]);
    }
}