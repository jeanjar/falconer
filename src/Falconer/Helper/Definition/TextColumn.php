<?php

namespace FalconerHelperDefinition;

class TextColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        $operations or $operations = array(
            'read' => array(),
            'item' => array(),
            'create' => array(),
            'update' => array(),
        );

        $result = array(
            'type' => Cdc_Definition::TYPE_COLUMN,
            Cdc_Definition::TYPE_WIDGET => array(
                'attributes' => array(
                    'maxlength' => $maxLength,
                ),
            ),
            Cdc_Definition::OPERATION => $operations,
            Cdc_Definition::TYPE_RULE => array(
                array('Cdc_Rule_Trim'),
                array('Cdc_Rule_Length', array($minLength, $maxLength)),
            ),
        );

        if ($classes_str)
        {
            $result[Cdc_Definition::TYPE_WIDGET]['attributes']['class'] = $classes_str;
        }

        if ($rules)
        {
            $result[Cdc_Definition::TYPE_RULE] = array_merge($result[Cdc_Definition::TYPE_RULE], $rules);
        }

        return $result;
    }
}
