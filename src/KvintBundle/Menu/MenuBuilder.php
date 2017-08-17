<?php

namespace KvintBundle\Menu;

use AppBundle\Entity\User;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface {
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factiory, array $options) {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->container->get('doctrine.orm.symf_portal_entity_manager');
        $listAllowed = $em->getRepository('AppBundle\Entity\User')->getRightsForLists($user);

        $menu = $factiory->createItem("root");
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        //$menu->setAttribute("class", "nav navbar-nav row");
        $menu->addChild("accounts", ['label' => 'Справочники'])->setAttribute('icon', 'fa fa-list')->setAttribute('dropdown', true);
        $menu->addChild("Документы", ['route' => 'kvint_documents'])->setAttribute('icon', 'fa fa-file-text');
        $menu['accounts']->addChild('kvint_tovar', array('route' => 'kvint_tovar', 'label' => 'Товары'));
        $menu['accounts']->addChild('kvint_grouptov', array('route' => 'kvint_grouptov', 'label' => 'Группы товара'))->setAttribute('divider_append', true);;
        if (in_array('kvint_spr_klient', $listAllowed)) {
            $menu['accounts']->addChild('kvint_klient', array('route' => 'kvint_klient', 'label' => 'Клиенты'))->setAttribute('divider_append', true);
        }
        if (in_array('kvint_spr_sklad', $listAllowed)) {
            $menu['accounts']->addChild('kvint_sklad', array('route' => 'kvint_sklad', 'label' => 'Склады'));
        }
        if (in_array('kvint_spr_trade_zone', $listAllowed)) {
            $menu['accounts']->addChild('kvint_trade_zone', array('route' => 'kvint_trade_zone', 'label' => 'Торг. зоны'));
        }
        if (in_array('kvint_spr_organization', $listAllowed)) {
            $menu['accounts']->addChild('kvint_ent', array('route' => 'kvint_ent', 'label' => 'Организации'));
        }
        return $menu;
    }
}