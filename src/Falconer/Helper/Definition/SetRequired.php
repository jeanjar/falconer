<?php

namespace FalconerHelperDefinition;

class SetRequired extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, ['column']);

        extract($args);

        if ($htmlAttribute)
        {
            $column[Cdc_Definition::TYPE_WIDGET]['attributes']['required'] = 'required';
        }

        $column[Cdc_Definition::TYPE_RULE][] = array('Cdc_Rule_Required');

        return $column;
    }
}
