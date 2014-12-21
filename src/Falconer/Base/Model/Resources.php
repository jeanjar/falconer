<?php

namespace Falconer\Base\Model;

use Phalcon\Mvc\Model\Validator\Uniqueness;

class Resources extends \Falconer\Base\Model
{
    public function getSource()
    {
        return "resources";
    }

    public function initialize()
    {
        $this->hasMany("id", "Falconer\Base\Model\UsersResources", "resource_id", array('alias' => 'Resources'));
    }

    public function validation()
    {
        $this->validate(new Uniqueness(
            array(
                "field" => 'resource',
                'message' => 'The resource must be unique'
            )
        ));

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

    public function getStruct() {
        ;
    }
}
