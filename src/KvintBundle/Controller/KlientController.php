<?php

namespace KvintBundle\Controller;

use AppBundle\Utils\EntityRightsChecker;
use KvintBundle\Datatables\KlientDatatable;
use KvintBundle\Entity\Klient;
use KvintBundle\Form\KlientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class KlientController extends Controller
{
    use EntityRightsChecker;
    private $entity_name = 'kvint_spr_klient';
    /**
     * @Route("/klient", name="kvint_klient")
     * @Template()
     */
    public function klientListAction(Request $request)
    {
        if (!$this->hasRight('list')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => 'Client dictionary. Access deny']);
        }
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(KlientDatatable::class);
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
     * @param Klient $klient
     *
     * @Route("/klient/show/{id}", name = "kvint_klient_show", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showKlientAction(Request $request, Klient $klient)
    {
        if (!$this->hasRight('view')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => 'View client dictinary element. Access deny']);
        }

        $form = $this->createForm(KlientType::class, $klient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('kvint_klient');
        }

        return $this->render('@Kvint/Klient/klientElement.html.twig', [
            'klientForm' => $form->createView(),
            'title' => ' клиента ' . $klient->getKname(),
            'type' => 'show',
        ]);
    }

    /**
     * @param Klient $klient
     *
     * @Route("/sklad/edit/{id}", name = "kvint_klient_edit", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function editKlientAction(Request $request, Klient $klient) {
        if (!$this->hasRight('edit')) {
            return $this->render("@Kvint/Default/err.html.twig", ['text' => 'Edit warehouse dictinary element. Access deny']);
        }

        $form = $this->createForm(SkladType::class, $klient);
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
     * @param Klient $klient
     *
     * @Route("/klient/remove/{id}", name = "kvint_klient_remove", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function removeSkladAction(Request $request, Klient $klient) {
        return new Response();
    }

    /**
     * @Route("/klient/add", name = "kvint_klient_add", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function addSkladAction(Request $request) {
        return new Response();
    }
}
