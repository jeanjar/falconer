<?php

namespace Falconer\Helper\Definition;

class SetRequired extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, ['column']);

        extract($args);

        if ($htmlAttribute)
        {
            $column[\Falconer\Definition::TYPE_WIDGET]['attributes']['required'] = 'required';
        }

        $column[\Falconer\Definition::TYPE_RULE][] = array('Cdc_Rule_Required');

        return $column;
    }
}
