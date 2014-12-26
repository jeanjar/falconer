<?php

namespace FalconerHelperDefinition;

class HiddenColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        $col = self::textColumn($classes_str, $rules, $maxLength, $minLength, $operations);
        $col[Cdc_Definition::TYPE_WIDGET]['widget'] = 'hidden';
        return $col;
    }
}
