<?php

namespace Falconer\Base\Model;

use Phalcon\Mvc\Model\Validator\Uniqueness;

class Groups extends \Falconer\Base\Model
{
    public $id;
    public $name;
    public $active;

    public function getSource()
    {
        return "groups";
    }

    public function initialize()
    {
        $this->useDynamicUpdate(true);

        $this->hasMany('id', 'Falconer\Base\Models\Users', 'group_id', array(
            'alias' => 'users',
            'foreignKey' => array(
                'message' => 'Group cannot be deleted because it\'s used on Users'
            )
        ));
        $this->hasMany("id", "Falconer\Base\Model\Resources", "group_id", array('alias' => 'resources'));
    }

    public function getStruct()
    {
        return $this->struct = array(

        );
    }

    public function getResources($params=null)
    {
        return $this->getRelated('Resources', $params);
    }

    public function validation()
    {
        $this->validate(new Uniqueness(
            array(
                "field" => 'name',
                'message' => 'The name must be unique'
            )
        ));

        if(is_null($this->active))
        {
            $this->active = true;
        }

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}
