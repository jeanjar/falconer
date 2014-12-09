<?php

namespace Falconer\Helper;

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
}
