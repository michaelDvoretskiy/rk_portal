<?php

namespace KvintBundle\Repository\Documents;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use KvintBundle\Entity\Documents\DocRow;
use KvintBundle\Entity\Documents\IncomeDocument;

class IncomeDocumentRepository extends EntityRepository {
    public function processChanges(IncomeDocument $doc, $options) {
        if ($options['type'] == 'update') {
            $originalData = $this->_em->getUnitOfWork()->getOriginalEntityData($doc);
            if ($doc->getStatus() != $originalData['status'] && in_array('T', [$doc->getStatus(),$originalData['status'] ])) {
                //document status was changed to passed or from passed
                //we need to create or delete movements for remains
                dump($doc->getStatus());
            } elseif ($originalData['status'] == 'T') {
                if ($doc->getWareHouse() != $originalData['wareHouse'] || $doc->getCustomer() != $originalData['customer']) {
                    //refill remains based on new customer or wareHouse
                    dump([$doc->getWareHouse(), $doc->getCustomer()]);
                }
            }
        }
    }
}