<?php

namespace AppBundle\Menu;

use AppBundle\Entity\User;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface {
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factiory, array $options) {
        $menu = $factiory->createItem("root");
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        //$menu->setAttribute("class", "nav navbar-nav row");
        $menu->addChild("Home", ['route' => 'homepage'])->setAttribute('icon', 'fa fa-home');
        $menu->addChild("Kvint", ['route' => 'kvint'])->setAttribute('icon', 'fa fa-truck');
        $menu->addChild("Portal", ['route' => 'portal'])->setAttribute('icon', 'fa fa-line-chart');
        $menu->addChild("About as", ['route' => 'about'])->setAttribute('icon', 'fa fa-info');
        return $menu;
    }
    public function loginMenu(FactoryInterface $factiory, array $options) {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
//        $user = new User();
        $menu = $factiory->createItem("root");
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        if($user instanceof User) {
            $menu->addChild("Logout (" . $user->getUsername() .")", ['route' => 'fos_user_security_logout'])->setAttribute('icon', 'glyphicon glyphicon-log-out');
        } else {
            $menu->addChild("Login", ['route' => 'fos_user_security_login'])->setAttribute('icon', 'glyphicon glyphicon-log-in');
        }
        return $menu;
    }
}