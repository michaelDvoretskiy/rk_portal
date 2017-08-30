<?php
/**
 * Created by PhpStorm.
 * User: M_Dvoretskiy
 * Date: 09.08.2017
 * Time: 16:14
 */

namespace KvintBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use KvintBundle\Entity\Tovar;

class TovarRepository extends EntityRepository {

    public function generateKod() {
        return KvintCodeGetter::getCode($this->getEntityManager("kvint"), "KvintBundle:Tovar");
    }

    public function getRemains(Tovar $tovar) {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("SNAME", "warehouse");
        $rsm->addScalarResult("kname", "supplier");
        $rsm->addScalarResult("CU", "productCost");
        $rsm->addScalarResult("kol", "quantity");
        $rsm->addScalarResult("pr1", "extra1");
        $rsm->addScalarResult("pr2", "extra2");

        $query = $this->_em->createNativeQuery("select k.kod, s.SNAME, isnull(p.KNAME, '') kname, k.CU, k.kol,
            cast(cast(round(case k.CU when 0 then 0 else (t.CO1 - k.CU * (1.0 + ISNULL(t.nds, 20.0)/100.0)) / (k.CU * (1.0 + ISNULL(t.nds, 20.0)/100.0)) end *100, 2) as decimal(8,2)) as varchar) + ' %' pr1, 
            cast(cast(round(case k.CU when 0 then 0 else (t.CO2 - k.CU * (1.0 + ISNULL(t.nds, 20.0)/100.0)) / (k.CU * (1.0 + ISNULL(t.nds, 20.0)/100.0)) end *100, 2) as decimal(8,2)) as varchar) + ' %' pr2
            from kart k inner join sklad s on k.SKLAD = s.kod left join klient p on k.PRT = p.kod inner join tovar t on k.kod = t.kod
            where t.kod = ?
            order by SNAME, kname", $rsm);
        $query->setParameter(1, $tovar->getKod());

        return $query->getResult();
    }

    public function getDopScanCodes($kod) {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("id_scan", "scanCode");
        $rsm->addScalarResult("kol", "quantity");

        $query = $this->_em->createNativeQuery("select id_scan, kol from dopscankod where kod = ? order by id_scan", $rsm);
        $query->setParameter(1, $kod);

        return $query->getResult();
    }

    public function getListByName($text, $first = 1, $limit = 20) {
        $qWhere = "t.tname like '%" . $text . "%'";
        if(ctype_digit($text)) {
            $qWhere = "(t.kod = " . $text . " or id_scan = '" . $text . "' or kod in(select kod from dopscankod where id_scan = '" . $text . "'))";
        }

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("kod", "id");
        $rsm->addScalarResult("tname", "text");

        $rsm2 = new ResultSetMapping();
        $rsm2->addScalarResult("c", "c");

        $last = $first + $limit - 1;
        $qText = "WITH dctrn_cte AS (SELECT DISTINCT TOP " . $last . " t.kod, t.tname from tovar t where t.act = 'T' and " . $qWhere . " ORDER BY t.tname ASC) 
            SELECT * FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY (SELECT 0)) AS doctrine_rownum FROM dctrn_cte) AS doctrine_tbl 
            WHERE doctrine_rownum BETWEEN " . $first . " AND " . $last . " ORDER BY doctrine_rownum ASC";
        $q = $this->_em->createNativeQuery($qText, $rsm);

        $q2 = $this->_em->createNativeQuery("select count(t.kod) c from tovar t where t.act = 'T' and " . $qWhere, $rsm2);
        return [$q->getResult(), $q2->getResult()];
    }
}