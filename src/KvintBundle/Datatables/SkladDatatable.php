<?php

namespace KvintBundle\Datatables;

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

        $this->options->set(array(
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
            'classes' => Style::BOOTSTRAP_3_STYLE, // or Style::BOOTSTRAP_3_STYLE.' table-condensed',
//            'dom' => '<lf>Btip',
        ));

        $this->features->set(array(
        ));

        $this->columnBuilder
            ->add('kod', Column::class, array(
                'title' => 'Код',
                'width' => "80px",
                ))
            ->add('sname', Column::class, array(
                'title' => 'Наименование',
                'width' => "350px",
                ))
            ->add(null, ActionColumn::class, array(
                'title' => '',//$this->translator->trans('sg.datatables.actions.title'),
                'width' => "70px",
                'actions' => array(
                    array(
                        'route' => 'kvint_sklad_show',
                        'route_parameters' => array(
                            'id' => 'kod'
                        ),
                        'label' => '', /*$this->translator->trans('sg.datatables.actions.show'),*/
                        'icon' => 'fa fa-tv',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.show'),
                            'class' => 'btn btn-success btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'kvint_sklad_edit',
                        'route_parameters' => array(
                            'id' => 'kod'
                        ),
                        'label' => '', /*$this->translator->trans('sg.datatables.actions.edit'),*/
                        'icon' => 'fa fa-pencil',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.edit'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'kvint_sklad_remove',
                        'route_parameters' => array(
                            'id' => 'kod'
                        ),
                        'label' => '', /*$this->translator->trans('sg.datatables.actions.edit'),*/
                        'icon' => 'glyphicon glyphicon-trash',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'delete',
                            'class' => 'btn btn-danger btn-xs',
                            'role' => 'button'
                        ),
                    )
                )
            ))
        ;
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
