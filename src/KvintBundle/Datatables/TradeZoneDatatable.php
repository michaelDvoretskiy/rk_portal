<?php

namespace KvintBundle\Datatables;

use AppBundle\Utils\DataTableUtil;
use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;

/**
 * Class EntDatatable
 *
 * @package KvintBundle\Datatables
 */
class TradeZoneDatatable extends AbstractDatatable
{
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

        $this->options->set(
            DataTableUtil::getOptions()
        );

        $this->features->set(
            DataTableUtil::getFeatures()
        );

        $this->columnBuilder
            ->add('kod', Column::class, array(
                'title' => 'Код',
                'width' => "80px",
            ))
            ->add('name', Column::class, array(
                'title' => 'Наименование',
                'width' => "350px",
            ))
            ->add(null, ActionColumn::class, DataTableUtil::getActions(
                "kvint_trade_zone",
                $this->translator->trans('sg.datatables.actions.show'),
                $this->translator->trans('sg.datatables.actions.edit'),
                ""
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'KvintBundle\Entity\TradeZone';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tradezone_datatable';
    }
}
