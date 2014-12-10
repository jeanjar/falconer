<?php

namespace Falconer\Base;

use Falconer\Definition;
use Falconer\Exception\Definition\DefinitionNotFound;

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
    
    private function _instanceDefinition($op = self::OPERATION_DEFAULT)
    {
        $definition = new Definition($this->getStruct(), $op);
        
        $this->setDefinition($definition);
    }
    
    public function getDefinition($operation = self::OPERATION_DEFAULT)
    {
        $this->_instanceDefinition($operation);
        
        if (!$this->definition)
        {
            throw new DefinitionNotFound;
        }
        
        $this->definition->reset();
        return $this->definition;
    }

    public function setDefinition(Definition $definition)
    {
        $definition->reset();
        $this->definition = $definition;
    }
}