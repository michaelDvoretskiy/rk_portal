<?php

namespace KvintBundle\Repository\Documents;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use KvintBundle\Entity\Documents\DocRow;
use KvintBundle\Entity\Documents\GoodsMovingDocument;

class GoodsMovingDocumentRepository extends EntityRepository {
    public function updateHeaderByTableValues($id, $username, $compName) {
        $conn = $this->_em->getConnection()->getWrappedConnection();
        $stmt = $conn->prepare("declare @res int, @SNDS numeric(15,6), @SU numeric(15,6), @SO numeric(15,6), @ST numeric(15,6)
            exec @res=spGetSumDok @KodDok=" . $id . ", @SumUC=@SU output, @SumOtp=@SO output, @SumTara=@ST output, @SumNDS=@SNDS output
            UPDATE RABFOLD SET SU=@SU, SO=@SO, SNDS=@SNDS, STARA=@ST WHERE Kod = " . $id
        );
        $stmt->execute();
        $results = array();
        do {
            try {
                $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\Exception $e) {}
        } while($stmt->nextRowset());
        $stmt->closeCursor(); // Clean up

        $conn = $this->_em->getConnection()->getWrappedConnection();
        $stmt = $conn->prepare("exec sp_SetSysGurn @KOD = " . $id . ", @TYP = 2, @UNAME = '" . $username . "', @COMP = '" . $compName . "'" );
        $stmt->execute();
        $results = array();
        do {
            try {
                $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\Exception $e) {}
        } while($stmt->nextRowset());
        $stmt->closeCursor(); // Clean up

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("SU", "sumOfCostPrice");
        $rsm->addScalarResult("SO", "sumOfSalePrice");
        $rsm->addScalarResult("SNDS", "sumOfNDS");
        $rsm->addScalarResult("STARA", "sumOfTara");
        $q = $this->_em->createNativeQuery("select SU, SO, SNDS, STARA from rabfold WHERE Kod = " . $id, $rsm);

        return $q->getResult();
    }

    function processStatusChange(GoodsMovingDocument $doc, $username, $compName) {
        $originalData = $this->_em->getUnitOfWork()->getOriginalEntityData($doc);
        if ($doc->getStatus() != $originalData['status']) {
            $conn = $this->_em->getConnection()->getWrappedConnection();
            if ($doc->getStatus() == 'T') {
                //process document passing

                /*run the procedure of autocasting, if we pass document from working folder*/
                if ($originalData['status'] == 'F') {
                    $stmt = $conn->prepare("exec sp_runAvtNac @kod = " . $doc->getKod() . ", @userName = '" . $username . "'
                    ");
                    $stmt->execute();
                    $results = array();
                    do {
                        try {
                            $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
                        }
                        catch (\Exception $e) {}
                    } while($stmt->nextRowset());

                    $stmt->closeCursor(); // Clean up
                }

                /*pass the document*/
                $stmt = $conn->prepare("exec sp_TranRunDok @kod = " . $doc->getKod() );
                $stmt->execute();
                $results = array();
                do {
                    try {
                        $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
                    }
                    catch (\Exception $e) {}
                } while($stmt->nextRowset());
                $stmt->closeCursor(); // Clean up

                /*add record to the journal of user activity*/
                $stmt = $conn->prepare("exec sp_SetSysGurn @KOD = " . $doc->getKod() . ", @TYP = 5, @UNAME = '" . $username . "', @COMP = '" . $compName . "'" );
                $stmt->execute();
                $results = array();
                do {
                    try {
                        $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
                    }
                    catch (\Exception $e) {}
                } while($stmt->nextRowset());
                $stmt->closeCursor(); // Clean up

                /*Call procedure of kvint on window close*/
                $stmt = $conn->prepare("exec sp_CloseSklDok @kod = " . $doc->getKod() . ", @oldProv = '" . $originalData['status'] . "'" );
                $stmt->execute();
                $results = array();
                do {
                    try {
                        $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
                    }
                    catch (\Exception $e) {}
                } while($stmt->nextRowset());
                $stmt->closeCursor(); // Clean up
            } elseif($originalData['status'] == 'T') {
                //process document pass deleting

                /*Call procedure that delete movements*/
                $stmt = $conn->prepare("exec sp_delNakl @kod = " . $doc->getKod() . ", @UseRecBin = 'T'" );
                $stmt->execute();
                $results = array();
                do {
                    try {
                        $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
                    }
                    catch (\Exception $e) {}
                } while($stmt->nextRowset());
                $stmt->closeCursor(); // Clean up

                /*add record to the journal of user activity*/
                $stmt = $conn->prepare("exec sp_SetSysGurn @KOD = " . $doc->getKod() . ", @TYP = 3, @UNAME = '" . $username . "', @COMP = '" . $compName . "'" );
                $stmt->execute();
                $results = array();
                do {
                    try {
                        $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
                    }
                    catch (\Exception $e) {}
                } while($stmt->nextRowset());

                $stmt->closeCursor(); // Clean up
            }
        }
    }

    public function processChanges(GoodsMovingDocument $doc, $options) {
        $beforeRezult = [];
        $originalData = $this->_em->getUnitOfWork()->getOriginalEntityData($doc);

        if ($doc->getStatus() == 'T' and ($doc->getCustomer() != $originalData['customer'] || $doc->getWareHouse() != $originalData['wareHouse'])) {
            $beforeRezult['need_refill_rows'] = true;
            $rows = $doc->getRows();
            foreach($rows as $row) {
                $this->_em->getRepository('KvintBundle:Documents\DocRow')->deleteRow($row);
            }
        }

        //write changes to sysgurn if there was some changes
        $this->_em->getUnitOfWork()->computeChangeSets();
        if ($this->_em->getUnitOfWork()->isEntityScheduled($doc)) {
            $flg = false;
            foreach($this->_em->getUnitOfWork()->getEntityChangeSet($doc) as $changes) {
                if($changes[0] != $changes[1]) {
                    $flg = true;
                }
            }
            if ($flg) {
                $conn = $this->_em->getConnection()->getWrappedConnection();
                $stmt = $conn->prepare("exec sp_SetSysGurn @KOD = " . $doc->getKod() . ", @TYP = 2, @UNAME = '" . $options['userName'] . "', @COMP = '" . $options['comp_name'] . "'" );
                $stmt->execute();
                $results = array();
                do {
                    try {
                        $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
                    }
                    catch (\Exception $e) {}
                } while($stmt->nextRowset());
                $stmt->closeCursor(); // Clean up
            }
        }


        return $beforeRezult;
    }

    public function processChangesAfter(GoodsMovingDocument $doc, $options, $beforeRezult = []) {
        $conn = $this->_em->getConnection()->getWrappedConnection();
        if (!is_null($beforeRezult['from_rep']) && isset($beforeRezult['from_rep']['need_refill_rows']) && $beforeRezult['from_rep']['need_refill_rows']) {
            $rows = $doc->getRows();
            foreach($rows as $row) {
                $this->_em->getRepository('KvintBundle:Documents\DocRow')->addRow($row);
            }
        }

        //recalculating document head
        $this->updateHeaderByTableValues($doc->getKod(), $options['userName'], $options['comp_name']);

        /*Call procedure of kvint on window close*/
        $stmt = $conn->prepare("exec sp_CloseSklDok @kod = " . $doc->getKod() . ", @oldProv = '" . $doc->getStatus() . "'" );
        $stmt->execute();
        $results = array();
        do {
            try {
                $results[] = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\Exception $e) {}
        } while($stmt->nextRowset());
        $stmt->closeCursor(); // Clean up

        return true;
    }

    public function getGeneralDocChangeJournal($id) {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("typ", "operType");
        $rsm->addScalarResult("dt", "dateTime");
        $rsm->addScalarResult("UNAME", "userName");
        $rsm->addScalarResult("comp", "compName");
        $q = $this->_em->createNativeQuery("select	case typ 
                    when 1 then 'Создан' 
                    when 2 then 'Изменен' 
                    when 3 then 'Удален' 
                    when 4 then 'Восстановлен' 
                    when 5 then 'Проведен' 
                end typ,
                CONVERT(varchar, dataop, 104) + ' ' + left(CONVERT(varchar, dataop, 114),8) dt,
                UNAME,
                comp
        from sysgurn
        where KOD = " . $id . " order by dataop", $rsm);

        return $q->getResult();
    }

    public function getRowsDocChangeJournal($id) {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("dt", "dateTime");
        $rsm->addScalarResult("kodtov", "tovarKod");
        $rsm->addScalarResult("tname", "tovarName");
        $rsm->addScalarResult("typ", "operType");
        $rsm->addScalarResult("uname", "userName");
        $rsm->addScalarResult("cuo", "oldCostPrice");
        $rsm->addScalarResult("cun", "newCostPrice");
        $rsm->addScalarResult("coo", "oldSalePrice");
        $rsm->addScalarResult("con", "newSalePrice");
        $rsm->addScalarResult("kolo", "oldQuantity");
        $rsm->addScalarResult("koln", "newQuantity");
        $rsm->addScalarResult("skid", "skid");
        $q = $this->_em->createNativeQuery("select CONVERT(varchar, data, 104) + ' ' + left(CONVERT(varchar, data, 114),8) dt, kodtov, tname, 
                case typ when 1 then 'Добавлена' when 2 then 'Изменена' when 3 then 'Удалена' end typ,
                uname, cuo, cun, coo, con, kolo, koln, skid
                from sysgurndok s inner join tovar t on s.kodtov = t.kod
                where s.kod = " . $id . " order by data desc", $rsm);

        return $q->getResult();
    }
}