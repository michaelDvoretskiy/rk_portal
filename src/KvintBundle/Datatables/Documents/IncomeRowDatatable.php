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
class IncomeRowDatatable extends AbstractDatatable
{
    use DataTableRightsChecker;

    public function getLineFormatter()
    {
        $formatter = function($row) {
            $row['saleSumma'] = number_format($row['salePrice'] * $row['incomeQuantity'], 2, '.', ' ');
            $row['jsActions'] = "<div class='my-row-action-btn' onclick='editDocRow(" . $row['id'] . ")'><i class='fa fa-pencil' aria-hidden='true'\"></i></div>
                <div class='my-row-action-btn' onclick='delDocRow(" . $row['id'] . ")'><i class='glyphicon glyphicon-trash my-action-delete' aria-hidden='true'></i></div>";
            $row['grdSalePrice'] = number_format($row['salePrice'] , 2, '.', ' ');
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
        ));

        $this->ajax->set(array(
        ));
        $this->ajax->setUrl($this->ajaxUrl);

        $opt = DataTableUtil::getOptions();
        $opt['order'] = [
            [2, 'asc'],
        ];
        $this->options->set($opt);
        $this->options->setDom('ltpr');

        $this->features->set(
            DataTableUtil::getFeatures()
        );

        $this->columnBuilder
            ->add('id', Column::class, array(
                'visible' => false,
            ))
            ->add('tovar.kod', Column::class, array(
                'title' => 'Код',
                'width' => "50px",
            ))
            ->add('tovar.tname', Column::class, array(
                'title' => 'Наименование',
                'width' => "200px",
            ))
            ->add('tovar.fasov', Column::class, array(
                'title' => 'Ед.',
                'width' => "30px",
            ))
            ->add('costPrice', Column::class, array(
                'title' => 'Цена уч.',
                'width' => "50px",
                'class_name' => 'align-right',
            ))
            ->add('incomeQuantity', Column::class, array(
                'title' => 'Кол',
                'width' => "50px",
                'class_name' => 'align-right',
            ))
            ->add('salePrice', Column::class, array(
                'visible' => false,
            ))
            ->add('grdSalePrice', VirtualColumn::class, array(
                'title' => 'Цена с НДС',
                'width' => "50px",
                'class_name' => 'align-right',
            ))
            ->add('saleSumma', VirtualColumn::class, array(
                'title' => 'Сумма',
                'width' => "50px",
                'orderable' => false,
                'class_name' => 'align-right',
            ))
            ->add('supplier.kname', Column::class, array(
                'title' => 'Поставщик',
                'width' => "150px",
            ))
            ->add('jsActions', VirtualColumn::class, array(
                'title' => '',
                'width' => "80px",
                'orderable' => false,
                'class_name' => 'align-center',
            ));

//        $this->addActions('kvint_documents_income',
//            $this->translator->trans('sg.datatables.actions.show'),
//            $this->translator->trans('sg.datatables.actions.edit'),
//            "delete"
//        );
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'KvintBundle\Entity\Documents\DocRow';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'income_document_row_datatable';
    }
}
