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
class GroupTovarDatatable extends AbstractDatatable
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
            [2, 'asc'],
        ];
        $this->options->set($opt);

        dump($this->options->getOrder());

        $this->features->set(
            DataTableUtil::getFeatures()
        );

        $this->columnBuilder
            ->add('kod', Column::class, array(
                'title' => 'Код',
                'width' => "80px",
                ))
            ->add('gname', Column::class, array(
                'title' => 'Группа',
                'width' => "350px",
                ))
            ->add('gname2', Column::class, array(
                'title' => 'Подгруппа',
                'width' => "350px",
        ));

        $this->addActions('kvint_grouptov',
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
        return 'KvintBundle\Entity\GroupTovar';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'grouptovar_datatable';
    }
}
