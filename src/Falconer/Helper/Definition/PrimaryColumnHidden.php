<?php

namespace FalconerHelperDefinition;

class PrimaryColumnHidden extends DefinitionHelper
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
            'type' => Cdc_Definition::TYPE_COLUMN,
            'primary' => true,
            Cdc_Definition::OPERATION => $operations,
            Cdc_Definition::TYPE_WIDGET => array(
                'widget' => 'hidden',
                'attributes' => array(
                    'class' => 'id',
                ),
            ),
            Cdc_Definition::TYPE_RULE => array(
                array('Cdc_Rule_Trim'),
            ),
        );
    }
}
