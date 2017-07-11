<?php

namespace KvintBundle\Datatables;

use AppBundle\Utils\DataTableRightsChecker;
use AppBundle\Utils\DataTableUtil;
use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;

/**
 * Class EntDatatable
 *
 * @package KvintBundle\Datatables
 */
class EntDatatable extends AbstractDatatable
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
            ));
        $this->addActions("kvint_ent",
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
        return 'KvintBundle\Entity\Ent';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ent_datatable';
    }
}
