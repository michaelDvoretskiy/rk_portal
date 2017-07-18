<?php

namespace KvintBundle\Datatables;

use AppBundle\Utils\DataTableRightsChecker;
use AppBundle\Utils\DataTableUtil;
use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\Column;

class KlientDatatable extends AbstractDatatable
{
    use DataTableRightsChecker;
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

        $this->options->set(
            DataTableUtil::getOptions()
        );

        $this->features->set(
            DataTableUtil::getFeatures()
        );

        $this->columnBuilder
            ->add('kod', Column::class, array(
                'title' => 'Код',
                'width' => "60px",
            ))
            ->add('kname', Column::class, array(
                'title' => 'Наименование',
                'width' => "250px",
            ))
            ->add('inn', Column::class, array(
            'title' => 'ИНН',
            'width' => "100px",
        ));

        $this->addActions('kvint_klient',
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
        return 'KvintBundle\Entity\Klient';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'klient_datatable';
    }
}