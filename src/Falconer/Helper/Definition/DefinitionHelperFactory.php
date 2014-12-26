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

        if(isset($args['namespace']))
        {
            $namespace = $args['namespace'];
        } else {
            $namespace = 'Falconer\Helper\Definition\\';
        }

        $f_class = ucfirst($namespace . $class);
        return $f_class::getStruct($args);
    }
}
