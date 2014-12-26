<?php

namespace Falconer\Helper\Definition;

class SlugColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        $operations or $operations = array(
            'item' => array(),
        );

        $result = array(
            'type' => \Falconer\Definition::TYPE_COLUMN,
            \Falconer\Definition::OPERATION => $operations,
        );

        return $result;
    }
}
