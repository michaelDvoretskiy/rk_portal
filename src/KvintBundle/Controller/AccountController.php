<?php

namespace KvintBundle\Controller;

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
}
