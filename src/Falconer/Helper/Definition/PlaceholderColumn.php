<?php

namespace Falconer\Helper\Definition;

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
            'type' => \Falconer\Definition::TYPE_COLUMN,
            'hide' => true,
            \Falconer\Definition::OPERATION => $operations,
        );
    }
}
