<?php

namespace KvintBundle\Controller;

use KvintBundle\Datatables\KlientDatatable;
use KvintBundle\Entity\Klient;
use KvintBundle\Entity\KvintListedEntities;
use KvintBundle\Form\KlientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        //$klient->synchroAttr();
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
        //$klient->synchroAttr();
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
    public function removeKlientAction(Klient $klient) {
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
    public function addKlientAction(Request $request) {
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

    /**
     * @return JsonResponse
     * @Route("/klient/filllist/ajax", name = "kvint_klient_list_ajax", options = {"expose" = true})
     */
    public function getAjaxKlientList(Request $request) {
        if (!$this->hasRight('view')) {
            return new JsonResponse();
        }
        $limit = $request->query->get('page_limit');
        $q = $request->query->get('q');
        $page = $request->query->get('page');
        if (!$page) {
            $page = 1;
        }

        $arrOfKlient = $this->getDoctrine()->getManager('kvint')->getRepository('KvintBundle:Klient')->getListByName($q, ($page - 1) * $limit, $limit);
        $ret['items'] = $arrOfKlient[0];
        if ($page == 1) {
            array_unshift($ret['items'], KvintListedEntities::emptyFieldForChoice());
        }

        $ret['total_count'] = $arrOfKlient[1][0]['c'];
        if ($ret['total_count'] > 1000) {
            $ret['total_count'] = 1000;
        }
        return new JsonResponse($ret);
    }
}