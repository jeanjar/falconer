<?php

namespace FalconerHelperDefinition;

class FileColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        $operations or $operations = array(
            'item' => array(),
            'create' => array(),
            'update' => array(),
        );
        $preset = (!empty($preset) ? $preset . '_' : ''). 'arquivo';

        $rules = [
        ];

        if (in_array('Multiple', $options))
        {
            $widget = 'multifile';
        }
        else
        {
            $widget = 'file';
        }


        if (in_array('Required', $options))
        {
            $rules[] = array('Rule_File_Required', array($preset));
        }

        return array(
            'type' => Cdc_Definition::TYPE_ATTACHMENT,
            Cdc_Definition::TYPE_ATTACHMENT => 'arquivo',
            //'data_format' => 'json',
            Cdc_Definition::TYPE_WIDGET => array(
                'widget' => $widget,
                'attributes' =>
                array(
                    'attachment_relation' => $preset,
                ),
            ),
            Cdc_Definition::OPERATION => $operations,
            Cdc_Definition::TYPE_RULE => $rules,
        );
    }
}
