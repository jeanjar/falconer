<?php

namespace FalconerHelperDefinition;

class RadioColumn extends DefinitionHelper
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
                'widget' => 'radio',
            ),
            Cdc_Definition::OPERATION => $operations,
            Cdc_Definition::TYPE_RULE => array(
                array('Cdc_Rule_Trim'),
                array('Cdc_Rule_ArrayKeyExists'),
            ),
        );

        if (is_callable($values))
        {
            $result[Cdc_Definition::TYPE_WIDGET]['callback'] = $values;
        }
        else
        {
            $result[Cdc_Definition::TYPE_WIDGET]['options'] = $values;
        }

        if ($classes_str)
        {
            $result[Cdc_Definition::TYPE_WIDGET]['attributes']['class'] = $classes_str;
        }


        return $result;
    }
}
