<?php

namespace AppBundle\Utils;

use Sg\DatatablesBundle\Datatable\Column\ActionColumn;

trait EntityRightsChecker {
    public function hasRight($right) {
        return $this->getDoctrine()->getManager('symf_portal')->getRepository('AppBundle:User')->checkRight($this->getUser(), $this->entity_name, $right);
    }
    public function getRights() {
        return $this->getDoctrine()->getManager('symf_portal')->getRepository('AppBundle:User')->getRights($this->getUser(), $this->entity_name);
    }
}