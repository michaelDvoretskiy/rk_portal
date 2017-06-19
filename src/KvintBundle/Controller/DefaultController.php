<?php

namespace KvintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="kvint")
     */
    public function indexAction()
    {
        return $this->render('KvintBundle:Default:index.html.twig');
    }
    /**
     * @Route("/accounts", name="kvint_accounts")
     */
    public function accountsAction()
    {
        return $this->render('KvintBundle:Default:index.html.twig');
    }
    /**
     * @Route("/documents", name="kvint_documents")
     */
    public function documentsAction()
    {
        return $this->render('KvintBundle:Default:index.html.twig');
    }
}
