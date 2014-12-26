<?php

namespace Falconer\Helper\Definition;

class BooleanColumn extends DefinitionHelper
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
            'type' => \Falconer\Definition::TYPE_COLUMN,
            \Falconer\Definition::TYPE_WIDGET => array(
                'widget' => 'boolean',
            ),
            \Falconer\Definition::OPERATION => $operations,
            \Falconer\Definition::TYPE_RULE => array(
                array('Cdc_Rule_Trim'),
                array('Cdc_Rule_Boolean'),
            ),
        );

        if (isset($classes_str))
        {
            $result[\Falconer\Definition::TYPE_WIDGET]['attributes']['class'] = $classes_str;
        }

        return $result;
    }
}
