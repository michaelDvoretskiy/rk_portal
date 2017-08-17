<?php

namespace KvintBundle\Controller\Catalogs;

use KvintBundle\Controller\KvintFormsController;
use KvintBundle\Datatables\EntDatatable;
use KvintBundle\Entity\Ent;
use KvintBundle\Form\EntType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EntController extends KvintFormsController
{
    protected $entity_name = 'kvint_spr_organization';
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/ent", name="kvint_ent")
     * @Template()
     */
    public function entListAction(Request $request)
    {
        return $this->listAction($request, EntDatatable::class, ['errTxt' => "Organization "]);
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
        return $this->showAction($request, $ent,
            [
                'errTxt' => 'organization',
                'form_type' => EntType::class,
                'form_name' => 'entForm',
                'route_return' => 'kvint_ent',
                'titleTxt' => ' организации ' . $ent->getName(),
                'template' =>  '@Kvint/Catalogs/Ent/entElement.html.twig',
            ]
        );
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
        return $this->editAction($request, $ent,
            [
                'errTxt' => 'organization',
                'form_type' => EntType::class,
                'form_name' => 'entForm',
                'route_return' => 'kvint_ent',
                'titleTxt' => ' организации ' . $ent->getName(),
                'template' =>  '@Kvint/Catalogs/Ent/entElement.html.twig',
            ]
        );
    }

    /**
     * @param Ent $ent
     *
     * @Route("/ent/remove/{id}", name = "kvint_ent_remove", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function removeEntAction(Request $request, Ent $ent) {
        return $this->removeAction($ent,
            [
                'errTxt' => 'organization',
                'route_return' => 'kvint_ent',
            ]
        );
    }

    /**
     * @param Sklad $sklad
     *
     * @Route("/ent/add", name = "kvint_ent_add", options = {"expose" = true})
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function addEntAction(Request $request) {
        return $this->addAction($request, new Ent(),
            [
                'errTxt' => 'organization',
                'form_type' => EntType::class,
                'form_name' => 'entForm',
                'route_return' => 'kvint_ent',
                'titleTxt' => ' организации ',
                'template' =>  '@Kvint/Catalogs/Ent/entElement.html.twig',
                'entity_name' => 'KvintBundle:Ent',
            ]
        );
    }
}