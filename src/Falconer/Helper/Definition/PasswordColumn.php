<?php

namespace FalconerHelperDefinition;

class PasswordColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, ['confirmation']);

        extract($args);

        $operations or $operations = array(
            'create' => array(),
            'change_password' => array(),
        );

        $result = array(
            'type' => Cdc_Definition::TYPE_COLUMN,
            Cdc_Definition::TYPE_WIDGET => array(
                'widget' => 'password',
                'attributes' => array(
                    'maxlength' => 32,
                ),
            ),
            Cdc_Definition::OPERATION => $operations,
            Cdc_Definition::TYPE_RULE => array(
                array('Cdc_Rule_Length', array(0, 32)),
            ),
        );

        if ($confirmation)
        {
            $result[Cdc_Definition::TYPE_RULE][] = array('Cdc_Rule_CompareFields', array($confirmation, label($confirmation)));
        }
        else
        {
            // Caso não haja confirmação significa que já é o campo de confirmação
            // que está sendo definido. Este atributo sinaliza que esta coluna deve
            // ser excluída na hora de construir o sql.
            $result[Cdc_Definition::OPERATION]['create']['virtual'] = true;
        }
        if ($classes_str)
        {
            $result[Cdc_Definition::TYPE_WIDGET]['attributes']['class'] = $classes_str;
        }

        return $result;
    }
}
