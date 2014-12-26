<?php

namespace Falconer\Helper\Definition;

class DateTimeColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        $operations or $operations = array(
            'read' => array(
                \Falconer\Definition::FORMATTER => array(
                    array('Cdc_CellDataFormatter', 'formatDate'), array('d-m-Y H:i:s'),
                ),
            ),
            'item' => array(),
            // 'create' => array(),
            'update' => array(),
        );

        $result = array(
            'type' => \Falconer\Definition::TYPE_COLUMN,
            \Falconer\Definition::TYPE_WIDGET => array(
                'widget' => 'datetime',
                'output_callback' => array(array('Cdc_OutputFormatter', 'date'), array('d/m/Y H:i:s')),
                'attributes' => array(
                    'class' => 'span3',
                ),
            ),
            \Falconer\Definition::OPERATION => $operations,
            \Falconer\Definition::TYPE_RULE => array(
                array('Cdc_Rule_Trim'),
                // array('Cdc_Rule_Date', array('Y-m-d')),
            ),
        );
        return $result;
    }
}
