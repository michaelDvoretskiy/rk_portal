<?php

namespace KvintBundle\Datatables\Documents;

use AppBundle\Utils\DataTableRightsChecker;
use AppBundle\Utils\DataTableUtil;
use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;

/**
 * Class SkladDatatable
 *
 * @package KvintBundle\Datatables
 */
class IncomeDatatable extends AbstractDatatable
{
    use DataTableRightsChecker;

    public function getLineFormatter()
    {
        $formatter = function($row) {
            $row['Grg2DocDate'] = substr($row['docDateStr'], 8, 2) . "." . substr($row['docDateStr'], 5, 2) . "." . substr($row['docDateStr'], 0, 4);
            $row['grdSumOfSalePrice'] = number_format($row['sumOfSalePrice'], 2, '.', ' ');
            return $row;
        };
        return $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->language->set(array(
            'cdn_language_by_locale' => true
            //'language' => 'de'
        ));

        $this->ajax->set(array(
        ));

        $opt = DataTableUtil::getOptions();
//        $opt['order'] = [
//            [1, 'asc'],
//        ];
        $this->options->set($opt);

        $this->features->set(
            DataTableUtil::getFeatures()
        );

        $this->columnBuilder
//            ->add('GrgDocDate', Column::class, array(
//                'title' => 'Дата',
//                'width' => "100px",
//                'dql' => "get_formatted_date(incomedocument.docDateStr, 104)",
//            ))
            ->add('Grg2DocDate', VirtualColumn::class, array(
                'title' => 'Дата',
                'width' => "100px",
                'orderable' => true,
                'order_column' => 'docDateStr',
            ))
            ->add('docDateStr', Column::class, array(
                'visible' => false,
            ))
            ->add('number', Column::class, array(
                'title' => 'Номер',
                'width' => "80px",
                ))
            ->add('wareHouse.sname', Column::class, array(
                'title' => 'Склад',
                'width' => "200px",
                'searchable' => false,
            ))
            ->add('customer.kname', Column::class, array(
                'title' => 'Клиент',
                'width' => "200px",
                'searchable' => false,
            ))
            ->add('sumOfSalePrice', Column::class, array(
                'visible' => false,
            ))
            ->add('grdSumOfSalePrice', VirtualColumn::class, array(
                'title' => 'Сумма',
                'width' => "90px",
                'orderable' => true,
                'order_column' => 'sumOfSalePrice',
                'class_name' => 'align-right',
            ))
            ->add('basis', Column::class, array(
                'title' => 'Основание',
                'width' => "150px",
            ));

        $this->addActions('kvint_tovar',
            $this->translator->trans('sg.datatables.actions.show'),
            $this->translator->trans('sg.datatables.actions.edit'),
            "delete"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'KvintBundle\Entity\Documents\IncomeDocument';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'income_document_datatable';
    }
}
