<?php

namespace Falconer\Helper\Definition;

class Relation extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);
        
        return array(
            'type' => Cdc_Definition::TYPE_RELATION,
            'statement_type' => Cdc_Definition::STATEMENT_SELECT,
            Cdc_Definition::OPERATION => array(
                'read' => array(),
                'item' => array(),
                'create' => array(
                    'statement_type' => Cdc_Definition::STATEMENT_INSERT,
                ),
                'update' => array(
                    'statement_type' => Cdc_Definition::STATEMENT_UPDATE,
                ),
                'delete' => array(
                    'statement_type' => Cdc_Definition::STATEMENT_DELETE,
                ),
            ),
        );
    }
}
