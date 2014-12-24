<?php

namespace Falconer\Helper\Definition;

abstract class DefinitionHelper implements DefinitionHelperInterface
{
    protected static function checkRequiredArgs($args = array(), $required = array())
    {
        $diff = array_diff_key(array_flip($required), $args);

        if(count($diff))
        {
            thrown \Exception('Missing args: ' . implode(',', array_flip($diff)));
        }

    }
}
