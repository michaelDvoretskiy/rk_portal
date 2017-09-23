<?php

namespace KvintBundle\Repository\Documents;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use KvintBundle\Entity\Documents\DocRow;

class  DocRowRepository extends EntityRepository {
    public function updateRow(DocRow $row) {
        $conn = $this->_em->getConnection()->getWrappedConnection();
        $originalData = $this->_em->getUnitOfWork()->getOriginalEntityData($row);
        $stmt = $conn->prepare("declare @res int
        exec @res = sp_TranUpdRabsod @Kod = " . $row->getDocument()->getKod() . ", @KodTov = " . $row->getTovar()->getKod() . ", @KolInUp = 1,
                                   @OldCU = " . $originalData['costPrice'] . ",  @NewCU  = " . $row->getCostPrice() . ",
                                   @NewCO = " . $row->getSalePrice() . ", @NewKol = " . $row->getIncomeQuantity() . ", @OldPrt  = " . $originalData['supplier']->getKod() . ",
                                   @NewPrt  = " . $row->getSupplier()->getKod() . "
        select @res rez");
        $stmt->execute();

        $results = array();
        do {
            try {
                $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\Exception $e) {}
        } while($stmt->nextRowset());

        $stmt->closeCursor(); // Clean up
        return $results;
    }

    public function deleteRow(DocRow $row) {
        $conn = $this->_em->getConnection()->getWrappedConnection();
        $originalData = $this->_em->getUnitOfWork()->getOriginalEntityData($row);
        $stmt = $conn->prepare("declare @res int
                exec @res = sp_TranDelRabsod @Kod = " . $row->getDocument()->getKod() . ", @KodTov = " . $row->getTovar()->getKod() . ", 
                @CU  = " . $row->getCostPrice() . ", @KolInUp = 1, @Prt  = " . $row->getSupplier()->getKod() . "
        select @res rez");
        $stmt->execute();

        $results = array();
        do {
            try {
                $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\Exception $e) {}
        } while($stmt->nextRowset());

        $stmt->closeCursor(); // Clean up
        return $results;
    }
}