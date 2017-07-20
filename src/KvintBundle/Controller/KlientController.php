<?php

namespace KvintBundle\Controller;

use KvintBundle\Datatables\KlientDatatable;
use KvintBundle\Entity\Klient;
use KvintBundle\Form\KlientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class KlientController extends KvintFormsController
{

    protected $entity_name = 'kvint_spr_klient';
    /**
     * @Route("/klient", name="kvint_klient")
     * @Template()
     */
    public function klientListAction(Request $request)
    {
        return $this->listAction($request, KlientDatatable::class, ['errTxt' => "Client"]);
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
        $klient->synchroAttr();
        return $this->showAction($request, $klient,
            [
                'errTxt' => 'client',
                'form_type' => KlientType::class,
                'form_name' => 'klientForm',
                'route_return' => 'kvint_klient',
                'titleTxt' => ' клиента ' . $klient->getKname(),
                'template' =>  '@Kvint/Klient/klientElement.html.twig',
            ]
        );
    }

    /**
     * @param Klient $klient
     *
     * @Route("/klient/edit/{id}", name = "kvint_klient_edit", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function editKlientAction(Request $request, Klient $klient) {
        $klient->synchroAttr();
        return $this->editAction($request, $klient,
            [
                'errTxt' => 'client',
                'form_type' => KlientType::class,
                'form_name' => 'klientForm',
                'route_return' => 'kvint_klient',
                'titleTxt' => ' клиента ' . $klient->getKname(),
                'template' =>  '@Kvint/Klient/klientElement.html.twig',
            ]
        );
    }

    /**
     * @param Klient $klient
     *
     * @Route("/klient/remove/{id}", name = "kvint_klient_remove", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function removeSkladAction(Klient $klient) {
        return $this->removeAction($klient,
            [
                'errTxt' => 'client',
                'route_return' => 'kvint_klient',
            ]
        );
    }

    /**
     * @Route("/klient/add", name = "kvint_klient_add", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function addSkladAction(Request $request) {
        return $this->addAction($request, new Klient(),
            [
                'errTxt' => 'client',
                'form_type' => KlientType::class,
                'form_name' => 'klientForm',
                'route_return' => 'kvint_klient',
                'titleTxt' => ' клиента ',
                'template' =>  '@Kvint/Klient/klientElement.html.twig',
                'entity_name' => 'KvintBundle:Klient',
            ]
        );
    }
}