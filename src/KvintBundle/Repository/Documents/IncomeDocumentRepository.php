<?php

namespace KvintBundle\Repository\Documents;

use Doctrine\ORM\EntityRepository;
use KvintBundle\Entity\Documents\DocRow;
use KvintBundle\Entity\Documents\IncomeDocument;

class IncomeDocumentRepository extends EntityRepository {

    public function processChangesAfter(IncomeDocument $doc, $options, $beforeRezult) {
        return $this->_em->getRepository('KvintBundle:Documents\GoodsMovingDocument')->processChangesAfter($doc, $options, $beforeRezult);
    }

    public function processChanges(IncomeDocument $doc, $options) {
        $uow = $this->_em->getUnitOfWork();
        $originalData = $uow->getOriginalEntityData($doc);

        $rez = $this->_em->getRepository('KvintBundle:Documents\GoodsMovingDocument')->processChanges($doc, $options);

        if ($doc->getCustomer() != $originalData['customer'] || $doc->getPercentOfNDS() != $originalData['percentOfNDS']) {
            $rows = $doc->getRows();
            foreach($rows as $row) {
                $row->setSupplier($doc->getCustomer());
                $row->setSalePrice($row->getCostPriceWithNdsDoc());
                $this->_em->persist($row);
            }
        }
        return $rez;
    }
}