<?php

namespace Falconer\Helper\Definition;

class PrimaryColumn extends DefinitionHelper
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
            'delete' => array(),
        );

        return array(
            'type' => \Falconer\Definition::TYPE_COLUMN,
            'primary' => true,
            'hide' => true,
            \Falconer\Definition::OPERATION => $operations,
        );
    }
}
