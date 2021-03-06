<?php

namespace Falconer\Helper\Definition;

class PrefixKeys extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, ['def', 'prefix', 'index']);

        extract($args);

        $result = array();
        if ($data)
        {
            foreach ($def as $key => $value)
            {
                $result["{$prefix}[{$index}][{$key}]"] = $value;
            }
        }
        else
        {
            foreach ($def as $key => $value)
            {
                if ($value['type'] == \Falconer\Definition::TYPE_COLUMN)
                {
                    $result["{$prefix}[{$index}][{$key}]"] = $value;
                }
            }
        }

        return $result;
    }
}
