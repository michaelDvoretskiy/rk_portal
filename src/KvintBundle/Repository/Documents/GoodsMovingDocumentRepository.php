<?php

namespace KvintBundle\Repository\Documents;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use KvintBundle\Entity\Documents\DocRow;

class GoodsMovingDocumentRepository extends EntityRepository {
    public function updateHeaderByTableValues($id) {
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare("declare @res int, @SNDS numeric(15,6), @SU numeric(15,6), @SO numeric(15,6), @ST numeric(15,6)
            exec @res=spGetSumDok @KodDok=" . $id . ", @SumUC=@SU output, @SumOtp=@SO output, @SumTara=@ST output, @SumNDS=@SNDS output
            UPDATE RABFOLD SET SU=@SU, SO=@SO, SNDS=@SNDS, STARA=@ST WHERE Kod = " . $id
        );
        dump($stmt);
        $stmt->execute();

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("SU", "sumOfCostPrice");
        $rsm->addScalarResult("SO", "sumOfSalePrice");
        $rsm->addScalarResult("SNDS", "sumOfNDS");
        $rsm->addScalarResult("STARA", "sumOfTara");
        $q = $this->_em->createNativeQuery("select SU, SO, SNDS, STARA from rabfold WHERE Kod = " . $id, $rsm);
        return $q->getResult();
    }
}