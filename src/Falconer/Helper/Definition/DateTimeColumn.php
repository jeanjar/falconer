<?php

namespace FalconerHelperDefinition;

class DateTimeColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        $operations or $operations = array(
            'read' => array(
                Cdc_Definition::FORMATTER => array(
                    array('Cdc_CellDataFormatter', 'formatDate'), array('d-m-Y H:i:s'),
                ),
            ),
            'item' => array(),
            // 'create' => array(),
            'update' => array(),
        );

        $result = array(
            'type' => Cdc_Definition::TYPE_COLUMN,
            Cdc_Definition::TYPE_WIDGET => array(
                'widget' => 'datetime',
                'output_callback' => array(array('Cdc_OutputFormatter', 'date'), array('d/m/Y H:i:s')),
                'attributes' => array(
                    'class' => 'span3',
                ),
            ),
            Cdc_Definition::OPERATION => $operations,
            Cdc_Definition::TYPE_RULE => array(
                array('Cdc_Rule_Trim'),
                // array('Cdc_Rule_Date', array('Y-m-d')),
            ),
        );
        return $result;
    }
}
