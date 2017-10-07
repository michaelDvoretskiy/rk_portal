<?php

namespace KvintBundle\Repository\Documents;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use KvintBundle\Entity\Documents\DocRow;

class  DocRowRepository extends EntityRepository {
    public function addRow(DocRow $row, $options) {
        $conn = $this->_em->getConnection()->getWrappedConnection();
        $stmt = $conn->prepare("declare @res int
        exec @res = sp_TranAddRabsod @Kod = " . $row->getDocument()->getKod() . ", @KodTov = " . $row->getTovar()->getKod() . ", @KolInUp = 1,
                                   @CU  = " . $row->getCostPrice() . ", @CO = " . $row->getCostPriceWithNdsDoc() . ", @Kol = " . $row->getIncomeQuantity() . ", 
                                   @prt  = " . $row->getSupplier()->getKod() . ", @R1 = 0, @R2 = 0                                   
        select @res rez
        insert into sysgurndok (kod, typ, uname, coo, con, kolo, koln, skid, kodtov, prov, cuo, cun, typd)  
        values(" . $row->getDocument()->getKod() . ", 1, '" . $options['user_name'] . "', null, " . $row->getCostPriceWithNdsDoc() . ",
        null, " . $row->getIncomeQuantity() . ", null, " . $row->getTovar()->getKod() . ", '" . $row->getDocument()->getStatus() . "', 
        null, " . $row->getCostPrice() . ", 1)");

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
//        return [
//           0 => ['rez' => 0, ],
//        ];
    }

    public function updateRow(DocRow $row, $options) {
        $conn = $this->_em->getConnection()->getWrappedConnection();
        $originalData = $this->_em->getUnitOfWork()->getOriginalEntityData($row);
        $stmt = $conn->prepare("declare @res int
        exec @res = sp_TranUpdRabsod @Kod = " . $row->getDocument()->getKod() . ", @KodTov = " . $row->getTovar()->getKod() . ", @KolInUp = 1,
                                   @OldCU = " . $originalData['costPrice'] . ",  @NewCU  = " . $row->getCostPrice() . ",
                                   @NewCO = " . $row->getSalePrice() . ", @NewKol = " . $row->getIncomeQuantity() . ", @OldPrt  = " . $originalData['supplier']->getKod() . ",
                                   @NewPrt  = " . $row->getSupplier()->getKod() . "
        select @res rez
        insert into sysgurndok (kod, typ, uname, coo, con, kolo, koln, skid, kodtov, prov, cuo, cun, typd)  
        values(" . $row->getDocument()->getKod() . ", 2, '" . $options['user_name'] . "', " . $originalData['salePrice'] . ", " . $row->getCostPriceWithNdsDoc() . ",
        " . $originalData['incomeQuantity'] . ", " . $row->getIncomeQuantity() . ", null, " . $row->getTovar()->getKod() . ", '" . $row->getDocument()->getStatus() . "', 
        " . $originalData['costPrice'] . ", " . $row->getCostPrice() . ", 1)");
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

    public function deleteRow(DocRow $row, $options) {
        $conn = $this->_em->getConnection()->getWrappedConnection();
        $stmt = $conn->prepare("declare @res int
                exec @res = sp_TranDelRabsod @Kod = " . $row->getDocument()->getKod() . ", @KodTov = " . $row->getTovar()->getKod() . ", 
                @CU  = " . $row->getCostPrice() . ", @KolInUp = 1, @Prt  = " . $row->getSupplier()->getKod() . "
        select @res rez
        insert into sysgurndok (kod, typ, uname, coo, con, kolo, koln, skid, kodtov, prov, cuo, cun, typd)  
        values(" . $row->getDocument()->getKod() . ", 3, '" . $options['user_name'] . "', " . $row->getCostPriceWithNdsDoc() . ", null, 
        " . $row->getIncomeQuantity() . ", null, null, " . $row->getTovar()->getKod() . ", '" . $row->getDocument()->getStatus() . "', 
        " . $row->getCostPrice() . ", null, 1)");
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

    public function refillRow(DocRow $row, $originalStuff) {
        $conn = $this->_em->getConnection()->getWrappedConnection();
        $stmt = $conn->prepare("declare @res int
                exec @res = sp_DelRabsod   @Kod = " . $row->getDocument()->getKod() . ", @KodTov = " . $originalData['tovar']->getKod() . ", 
                @CU  = " . $originalData['costPrice'] . ", @KolInUp = 1, @UseRecBin = 'F', @Prt  = " . $originalStuff['supplierKod'] . "
        if @res=0
        begin
            exec @res = sp_AddRabsod @Kod = " . $row->getDocument()->getKod() . ", @KodTov = " . $row->getTovar()->getKod() . ", @KolInUp = 1,
                                   @CU  = " . $row->getCostPrice() . ", @CO = " . $row->getCostPriceWithNdsDoc() . ", @Kol = " . $row->getIncomeQuantity() . ", 
                                   @prt  = " . $row->getSupplier()->getKod() . ", @R1 = 0, @R2 = 0
        end
        select @res res");
        $stmt->execute();
        dump($stmt);

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