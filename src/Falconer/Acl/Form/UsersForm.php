<?php

namespace Falconer\Acl\Form;

use Falconer\Base\Form;

class UsersForm extends Form
{
    
    public function initialize($user, array $options)
    {
        $this->setEntity($this);
        
        parent::initialize();
        
        $this->struct = $this->getStruct($user);
    }
}