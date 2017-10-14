<?php

namespace KvintBundle\Entity\Documents;

use AppBundle\Utils\AmountInWords;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KvintBundle\Repository\Documents\IncomeDocumentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class IncomeDocument extends GoodsMovingDocument {
    public function getArrayToPrint() {
        $arr['title'] = 'Прибуткова накладна ' . $this->getDocTitle(" від ");
        $arr['attrList'] = [
            ['caption' => 'Склад', 'value' => $this->getWareHouse()->getSname()],
            ['caption' => 'Постачальник', 'value' => $this->getCustomer()->getKname()],
            ['caption' => 'Довіреність', 'value' => $this->getProxyPaper()],
            ['caption' => 'Через', 'value' => $this->getProxyPerson()],
            ['caption' => 'Підстава', 'value' => $this->getBasis()],
        ];

        $arr['attrListFooter'] = [
            ['caption' => 'Разом сума прописом', 'value' => AmountInWords::num2text_ua($this->getSumOfSalePrice())],
        ];

        $goodsTable = [];
        $goodsTable['head'] = [
            ['caption' => '№'],
            ['caption' => 'Код'],
            ['caption' => 'Найменування'],
            ['caption' => 'УКТЗЕД'],
            ['caption' => 'Од'],
            ['caption' => 'Кіл-ть'],
            ['caption' => 'Ціна без ПДВ'],
            ['caption' => 'Сума без ПДВ'],
        ];

        $goodsTable['foot'] = [
            ['caption' => 'Разом сума без ПДВ :', 'value' => number_format($this->getSumOfCostPrice(),2), 'valColSpan' => 1],
            ['caption' => 'ПДВ :', 'value' => number_format($this->getSumOfNDS(),2), 'valColSpan' => 1],
        ];
        if ($this->getSumOfFare() != 0) {
            $goodsTable['foot'][] = ['caption' => 'Транспортні витрати :', 'value' => number_format($this->getSumOfFare(),2), 'valColSpan' => 1];
        }
        $goodsTable['foot'][] = ['caption' => 'Разом по накладній :', 'value' => number_format($this->getSumOfSalePrice(),2), 'valColSpan' => 1];

        $goodsTable['rows'] = [];
        $row_numb = 1;
        foreach($this->getRowsSortedByName() as $row) {
            $goodsTable['rows'][] = [
                ['value' => $row_numb],
                ['value' => $row->getTovar()->getKod()],
                ['value' => $row->getTovar()->getTname()],
                ['value' => $row->getTovar()->getKved()],
                ['value' => $row->getTovar()->getFasov()],
                ['value' => $row->getIncomeQuantity(), 'styleClass' => 'doc-td-right'],
                ['value' => $row->getCostPrice(), 'styleClass' => 'doc-td-right'],
                ['value' => number_format($row->getCostPrice() * $row->getIncomeQuantity(), 2), 'styleClass' => 'doc-td-right'],
            ];
            $row_numb++;
        }
        $arr['tables'] = [
            $goodsTable,
        ];
        return $arr;
    }
}