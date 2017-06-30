<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/usersedit/{id}", name = "edit_user")
     */
    public function editUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager('symf_portal');
        $user = $em->getRepository('AppBundle:User')->find($id);

        dump($user->getRoles());
        if (!is_object($user)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm(['action'=>$this->generateUrl('edit_user', ['id' => $id])]);
        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $user = $form->getData();
            //$userManager->updateUser($user);
            dump($user);
//            $session = $this->getRequest()->getSession();
//            $session->getFlashBag()->add('message', 'Successfully updated');
//            $url = $this->generateUrl('matrix_edi_viewUser');
//            $response = new RedirectResponse($url);
        }

        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
