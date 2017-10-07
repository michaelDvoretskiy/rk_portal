<?php

namespace AppBundle\Utils;

use Sg\DatatablesBundle\Datatable\Column\ActionColumn;

trait DataTableRightsChecker {
    public $rights;
    public $returnParameters = array();
    public $ajaxUrl = null;

    public function addActions($path, $show, $edit, $delete, $others = []) {
        $preparedActions = DataTableUtil::getActions(
            $path,
            $show, //$this->translator->trans('sg.datatables.actions.show'),
            $edit, //$this->translator->trans('sg.datatables.actions.edit'),
            $delete, //"delete",
            $others,
            $this->rights,
            $this->returnParameters
        );
        if ($preparedActions['actions']) {
            $this->columnBuilder->add(null, ActionColumn::class, $preparedActions);
        }
    }
}