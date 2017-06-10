<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface {
    use ContainerAwareTrait;
    public function mainMenu(FactoryInterface $factiory, array $options) {
        $menu = $factiory->createItem("root");
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        //$menu->setAttribute("class", "nav navbar-nav row");
        $menu->addChild("Home", ['route' => 'homepage']);
        $menu->addChild("About as", ['route' => 'about']);

        return $menu;
    }
}