<?php

namespace Falconer\Base;

use Phalcon\Forms\Element\Hidden;

abstract class Form extends \Phalcon\Forms\Form
{
    
    public function getCsrf()
    {
        return $this->security->getToken();
    }

    public function initialize()
    {
        $this->add(new Hidden("csrf"));
        
    }
    
    public function render()
    {
        
    }
}