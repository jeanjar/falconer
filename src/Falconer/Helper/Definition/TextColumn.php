<?php

namespace Falconer\Helper\Definition;

class TextColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        if(!isset($minLength))
        {
            $minLength = 0;
        }

        if(!isset($maxLength))
        {
            $maxLength = 150;
        }

        $operations or $operations = array(
            'read' => array(),
            'item' => array(),
            'create' => array(),
            'update' => array(),
        );

        $result = array(
            'type' => \Falconer\Definition::TYPE_COLUMN,
            \Falconer\Definition::TYPE_WIDGET => array(
                'attributes' => array(
                    'maxlength' => $maxLength,
                ),
            ),
            \Falconer\Definition::OPERATION => $operations,
            \Falconer\Definition::TYPE_RULE => array(
                array('Cdc_Rule_Trim'),
                array('Cdc_Rule_Length', array($minLength, $maxLength)),
            ),
        );

        if (isset($classes_str))
        {
            $result[\Falconer\Definition::TYPE_WIDGET]['attributes']['class'] = $classes_str;
        }

        if (isset($rules))
        {
            $result[\Falconer\Definition::TYPE_RULE] = array_merge($result[\Falconer\Definition::TYPE_RULE], $rules);
        }

        return $result;
    }
}
