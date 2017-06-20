<?php

namespace KvintBundle\Controller;

use KvintBundle\Datatables\SkladDatatable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{
    /**
     * @Route("/accounts/tovar", name="kvint_tovar")
     */
    public function tovarAction()
    {
        return $this->render('KvintBundle:Default:index.html.twig');
    }
    /**
     * @Route("/accounts/klient", name="kvint_klient")
     */
    public function klientAction()
    {
        return $this->render('KvintBundle:Default:index.html.twig');
    }
    /**
     * @Route("/accounts/sklad", name="kvint_sklad")
     * @Method("GET")
     * @Template()
     */
    public function skladAction(Request $request)
    {
//        $sklad = $this->getDoctrine()->getManager("kvint") ->getRepository("KvintBundle:Sklad")->find(115);
//        dump($sklad);


        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(SkladDatatable::class);
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);

            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();

            //dump($datatableQueryBuilder->getQb()->getDQL()); die();

            return $responseService->getResponse();
        }

        return [
            'datatable' => $datatable,
        ];
    }

    /**
     * Finds and displays a Sklad entity.
     *
     * @param Post $post
     *
     * @Route("/accounts/sklad/show/{id}", name = "kvint_sklad_show", options = {"expose" = true})
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showSkladAction(Post $post)
    {
        dump($post);
        return "";
        return $this->render('post/show.html.twig', array(
            'post' => $post
        ));
    }

    /**
     * Finds and displays a Sklad entity.
     *
     * @param Post $post
     *
     * @Route("/accounts/sklad/edit/{id}", name = "kvint_sklad_edit", options = {"expose" = true})
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function editSkladAction(Post $post) {

        dump($post);
        return $this->render('post/show.html.twig', array(
            'post' => $post
        ));
    }
}
