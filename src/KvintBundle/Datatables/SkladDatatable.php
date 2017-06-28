<?php

namespace KvintBundle\Datatables;

use AppBundle\Utils\DataTableUtil;
use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Editable\CombodateEditable;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextareaEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;

/**
 * Class SkladDatatable
 *
 * @package KvintBundle\Datatables
 */
class SkladDatatable extends AbstractDatatable
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
            ->add('sname', Column::class, array(
                'title' => 'Наименование',
                'width' => "350px",
                ))
            ->add(null, ActionColumn::class, DataTableUtil::getActions(
                'kvint_sklad',
                $this->translator->trans('sg.datatables.actions.show'),
                $this->translator->trans('sg.datatables.actions.edit'),
                "delete"
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'KvintBundle\Entity\Sklad';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sklad_datatable';
    }
}
