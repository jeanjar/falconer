<?php

namespace FalconerHelperDefinition;

class RichColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        $operations or $operations = array(
            'item' => array(),
            'create' => array(),
            'update' => array(),
        );

        $result = array(
            'type' => Cdc_Definition::TYPE_COLUMN,
            Cdc_Definition::TYPE_WIDGET => array(
                'widget' => 'rich',
            ),
            Cdc_Definition::OPERATION => $operations,
            Cdc_Definition::TYPE_RULE => array(
                array('Cdc_Rule_Trim'),
            ),
        );

        return $result;
    }
}
