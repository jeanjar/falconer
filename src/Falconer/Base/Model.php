<?php

namespace Falconer\Base;

abstract class Model extends \Phalcon\Mvc\Model
{
    protected $struct;
    
    abstract function getStruct();
    
    public function fillAttr(array $attrs)
    {
        foreach($attrs as $k => $v)
        {
            $this->$k = $v;
        }
    }
}