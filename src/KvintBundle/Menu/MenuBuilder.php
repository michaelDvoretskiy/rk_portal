<?php

namespace KvintBundle\Menu;

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
        $menu->addChild("accounts", ['label' => 'Справочники'])->setAttribute('icon', 'fa fa-list')->setAttribute('dropdown', true);
        $menu->addChild("Документы", ['route' => 'kvint_documents'])->setAttribute('icon', 'fa fa-file-text');
        $menu['accounts']->addChild('kvint_tovar', array('route' => 'kvint_tovar', 'label' => 'Товары'));
        $menu['accounts']->addChild('kvint_klient', array('route' => 'kvint_klient', 'label' => 'Клиенты'))->setAttribute('divider_append', true);
        $menu['accounts']->addChild('kvint_sklad', array('route' => 'kvint_sklad', 'label' => 'Склады'));
//        $menu['accounts']->addChild('divider1', ['divider' => true, 'label' => '', 'class'=>'divider']);
        $menu['accounts']->addChild('kvint_ent', array('route' => 'kvint_ent', 'label' => 'Организации'));
        return $menu;
    }
}