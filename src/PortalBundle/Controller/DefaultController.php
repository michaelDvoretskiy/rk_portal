<?php

namespace PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="portal")
     */
    public function indexAction()
    {
        return $this->render('PortalBundle:Default:index.html.twig');
    }
}
