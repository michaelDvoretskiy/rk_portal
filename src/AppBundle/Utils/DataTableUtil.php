<?php

namespace AppBundle\Utils;

use Sg\DatatablesBundle\Datatable\Style;

class DataTableUtil {
    public static function getActions($path, $show, $edit, $delete, $rights = ['view' => true, 'add' => 'false', 'edit' => false, 'delete' => false], $returnParameters = array()) {
        $returnParameters['id'] = 'kod';
        $res = [
            'title' => '', //$this->translator->trans('sg.datatables.actions.title'),
            'width' => "70px",
            'class_name' => 'centered'
        ];
        $actions = [];
        if ($show && $rights['view']) {
            $actions[] = [
                'route' => $path . '_show',
                'route_parameters' => $returnParameters,
                'label' => '', /*$this->translator->trans('sg.datatables.actions.show'),*/
                'icon' => 'fa fa-tv',
                'attributes' => array(
                    'rel' => 'tooltip',
                    'title' => $show, #$this->translator->trans('sg.datatables.actions.show'),
                    'class' => 'btn btn-success btn-xs',
                    'role' => 'button'
                ),
            ];
        }
        if ($edit && $rights['edit']) {
            $actions[] = [
                'route' => $path . '_edit',
                'route_parameters' => $returnParameters,
                'label' => '', /*$this->translator->trans('sg.datatables.actions.edit'),*/
                'icon' => 'fa fa-pencil',
                'attributes' => array(
                    'rel' => 'tooltip',
                    'title' => $edit,
                    'class' => 'btn btn-primary btn-xs',
                    'role' => 'button'
                ),
            ];
        }
        if ($delete && $rights['delete']) {
            $actions[] = [
                'route' => $path . '_remove',
                'route_parameters' => $returnParameters,
                'confirm' => true,
                'confirm_message' => 'Удалить элемент ?',
                'label' => '',
                'icon' => 'glyphicon glyphicon-trash',
                'attributes' => array(
                    'rel' => 'tooltip',
                    'title' => $delete,
                    'class' => 'btn btn-danger btn-xs',
                    'role' => 'button'
                ),
            ];
        }

        $res['actions'] = $actions;
        $res['width'] = "150px";

        return $res;

    }

    public static function getOptions() {
        return [
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
            'classes' => Style::BOOTSTRAP_3_STYLE . " table-hover", // or Style::BOOTSTRAP_3_STYLE.' table-condensed',
        ];
    }

    public static function getFeatures() {
        return [
            "state_save" => true,
        ];
    }
}