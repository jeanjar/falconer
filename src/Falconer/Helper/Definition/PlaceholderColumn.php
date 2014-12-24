<?php

namespace FalconerHelperDefinition;

class PlaceholderColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);
        
        $operations or $operations = array(
            'create' => array(),
        );

        return array(
            'type' => Cdc_Definition::TYPE_COLUMN,
            'hide' => true,
            Cdc_Definition::OPERATION => $operations,
        );
    }
}
