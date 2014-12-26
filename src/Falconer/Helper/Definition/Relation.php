<?php

namespace Falconer\Helper\Definition;

class Relation extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        return array(
            'type' => \Falconer\Definition::TYPE_RELATION,
            'statement_type' => \Falconer\Definition::STATEMENT_SELECT,
            \Falconer\Definition::OPERATION => array(
                'read' => array(),
                'item' => array(),
                'create' => array(
                    'statement_type' => \Falconer\Definition::STATEMENT_INSERT,
                ),
                'update' => array(
                    'statement_type' => \Falconer\Definition::STATEMENT_UPDATE,
                ),
                'delete' => array(
                    'statement_type' => \Falconer\Definition::STATEMENT_DELETE,
                ),
            ),
        );
    }
}
