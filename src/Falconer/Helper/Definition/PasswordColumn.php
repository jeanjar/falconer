<?php

namespace Falconer\Helper\Definition;

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
            'type' => \Falconer\Definition::TYPE_COLUMN,
            \Falconer\Definition::TYPE_WIDGET => array(
                'widget' => 'password',
                'attributes' => array(
                    'maxlength' => 32,
                ),
            ),
            \Falconer\Definition::OPERATION => $operations,
            \Falconer\Definition::TYPE_RULE => array(
                array('Cdc_Rule_Length', array(0, 32)),
            ),
        );

        if (isset($confirmation_field))
        {
            $result[\Falconer\Definition::TYPE_RULE][] = array('\Falconer\Rule\CompareFields', array($confirmation, label($confirmation)));
        }
        else if (isset($is_confirmation))
        {
            // Caso não haja confirmação significa que já é o campo de confirmação
            // que está sendo definido. Este atributo sinaliza que esta coluna deve
            // ser excluída na hora de construir o sql.
            $result[\Falconer\Definition::OPERATION]['create']['virtual'] = true;
        }
        if (isset($classes_str))
        {
            $result[\Falconer\Definition::TYPE_WIDGET]['attributes']['class'] = $classes_str;
        }

        return $result;
    }
}
