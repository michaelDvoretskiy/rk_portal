<?php

namespace AppBundle\Utils;

use Sg\DatatablesBundle\Datatable\Column\ActionColumn;

trait DataTableRightsChecker {
    public $rights;

    public function addActions($path, $show, $edit, $delete) {
        $preparedActions = DataTableUtil::getActions(
            'kvint_sklad',
            $this->translator->trans('sg.datatables.actions.show'),
            $this->translator->trans('sg.datatables.actions.edit'),
            "delete",
            $this->rights
        );
        if ($preparedActions['actions']) {
            $this->columnBuilder->add(null, ActionColumn::class, $preparedActions);
        }
    }
}