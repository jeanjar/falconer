<?php

namespace Falconer\Helper\Definition;

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
            'type' => \Falconer\Definition::TYPE_COLUMN,
            'primary' => true,
            \Falconer\Definition::OPERATION => $operations,
            \Falconer\Definition::TYPE_WIDGET => array(
                'widget' => 'hidden',
                'attributes' => array(
                    'class' => 'id',
                ),
            ),
            \Falconer\Definition::TYPE_RULE => array(
                array('Cdc_Rule_Trim'),
            ),
        );
    }
}
