<?php

namespace KvintBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
     * @Template()
     */
    public function skladAction()
    {
        $sklad = $this->getDoctrine()->getManager("kvint") ->getRepository("KvintBundle:Sklad")->find(115);
        dump($sklad);
        return [];
    }
}
