<?php

namespace AppBundle\Utils;

use Sg\DatatablesBundle\Datatable\Style;

class DataTableUtil {
    public static function getActions($path, $show, $edit, $delete) {
        $res = [
            'title' => '',//$this->translator->trans('sg.datatables.actions.title'),
            'width' => "70px",
            'class_name' => 'centered'
        ];
        $actions = [];
        if ($show) {
            $actions[] = [
                'route' => $path . '_show',
                'route_parameters' => array(
                    'id' => 'kod'
                ),
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
        if ($edit) {
            $actions[] = [
                'route' => $path . '_edit',
                'route_parameters' => array(
                    'id' => 'kod'
                ),
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
        if ($delete) {
            $actions[] = [
                'route' => $path . '_remove',
                'route_parameters' => array(
                    'id' => 'kod'
                ),
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

        return $res;

    }

    public static function getOptions() {
        return [
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
            'classes' => Style::BOOTSTRAP_3_STYLE, // or Style::BOOTSTRAP_3_STYLE.' table-condensed',
        ];
    }

    public static function getFeatures() {
        return [
            "state_save" => true,
        ];
    }
}