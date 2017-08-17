<?php

namespace KvintBundle\Datatables;

use AppBundle\Utils\DataTableRightsChecker;
use AppBundle\Utils\DataTableUtil;
use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\Column;

/**
 * Class SkladDatatable
 *
 * @package KvintBundle\Datatables
 */
class TovarDatatable extends AbstractDatatable
{
    use DataTableRightsChecker;
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
//        $opt['order_multi'] = true;
        $opt['order'] = [
            [1, 'asc'],
        ];
        $this->options->set($opt);

        $this->features->set(
            DataTableUtil::getFeatures()
        );

        $this->columnBuilder
            ->add('kod', Column::class, array(
                'title' => 'Код',
                'width' => "60px",
                ))
            ->add('tname', Column::class, array(
                'title' => 'Группа',
                'width' => "220px",
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
        return 'KvintBundle\Entity\Tovar';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'grouptovar_datatable';
    }
}
