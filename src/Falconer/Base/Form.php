<?php

namespace Falconer\Base;

use Phalcon\Forms\Element\Hidden;

abstract class Form extends \Phalcon\Forms\Form
{
    
    public function getStruct($model)
    {
        $di = \Phalcon\DI\FactoryDefault::getDefault();
        $fields = $di['db']->describeColumns($model->getSource());
        
        $struct = array();
        foreach($fields as $column)
        {
            $struct[$column->getName()] = $column->getType();
        }
        
        
        var_dump($struct);
        die;
    }
    
    public $struct = array();
    
    public function getCsrf()
    {
        return $this->security->getToken();
    }

    public function initialize()
    {
        $this->add(new Hidden("csrf"));
        
    }
}