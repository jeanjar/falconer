<?php

namespace Falconer\Base;

abstract class Model extends \Phalcon\Mvc\Model
{
    protected $struct;
    protected $definition;
    
    const OPERATION_DEFAULT = 'item';
    
    abstract function getStruct();
    
    public function fillAttr(array $attrs)
    {
        foreach($attrs as $k => $v)
        {
            $this->$k = $v;
        }
    }
    
    public function getDefinition($operation = self::OPERATION_DEFAULT)
    {
        if (!$this->definition)
        {
            throw new Cdc_Exception_DefinitionNotFound;
        }
        $this->definition->reset();
        return $this->definition;
    }

    public function setDefinition(Cdc_Definition $definition)
    {
        $definition->reset();
        $this->definition = $definition;
    }
}