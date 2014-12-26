<?php

namespace Falconer\Helper\Definition;

class DefinitionHelperFactory
{
    public static function get($class, $args = array())
    {
        if(!isset($args['operations']))
        {
            $args['operations'] = array();
        }

        $f_class = ucfirst('Falconer\Helper\Definition\\' . $class);
        return $f_class::getStruct($args);
    }
}
