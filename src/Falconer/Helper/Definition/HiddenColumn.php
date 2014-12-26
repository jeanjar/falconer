<?php

namespace Falconer\Helper\Definition;

class HiddenColumn extends DefinitionHelper
{
    public static function getStruct($args = array())
    {
        self::checkRequiredArgs($args, []);

        extract($args);

        $col = TextColumn::getStruct($args);
        $col[\Falconer\Definition::TYPE_WIDGET]['widget'] = 'hidden';
        return $col;
    }
}
