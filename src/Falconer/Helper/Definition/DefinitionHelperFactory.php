<?php

namespace Falconer\Helper\Definition;

class DefinitionHelperFactory
{
    public static function get($class, $args)
    {
        $f_class = ucfirst($class);
        return $f_class::getStruct($args);
    }
}
