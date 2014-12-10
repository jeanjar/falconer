<?php

namespace Falconer\Helper;

use Falconer\Definition;

class Core
{

    public static function coalesce(/* ... */)
    {
        $args = func_get_args();
        foreach ($args as $arg)
        {
            if (null !== $arg && '' !== $arg)
            {
                return $arg;
            }
        }
    }

    public static function mask($mask, $string)
    {
        $string = str_replace(" ", "", $string);
        for ($i = 0; $i < strlen($string); $i++)
        {
            $pos = strpos($mask, "#");
            if ($pos !== false)
            {
                $mask[$pos] = $string[$i];
            }
            else
            {
                $mask .= $string[$i];
            }
        }
        return $mask;
    }

    public static function filter($type, $variable_name, $filter = FILTER_DEFAULT, $options = null)
    {
        if (is_array($type))
        {
            if (isset($type[$variable_name]))
            {
                return filter_var($type[$variable_name], $filter, $options);
            }
            return null;
        }
        return filter_input($type, $variable_name, $filter, $options);
    }

    public static function label($index, $labels = array())
    {
        if (!$labels)
        {
            $labels = [];
        }

        if (isset($labels[$index]))
        {
            if (is_string($labels[$index]))
            {
                return ucfirst($labels[$index]);
            }
        }
        return $index;
    }

    function required($def, $requiredText = '<span class="required_token"> *</span>')
    {
        if (isset($def[Definition::TYPE_WIDGET]['attributes']['required']))
        {
            return $requiredText;
        }

        if (array_key_exists(Definition::TYPE_RULE, $def))
        {
            $index = array_search(array('Rule_Required'), $def[Definition::TYPE_RULE]);
            if ($index !== false)
            {
                return $requiredText;
            }
        }
    }

}
