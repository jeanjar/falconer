<?php

namespace Falconer\Acl\Model;

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

        $this->hasOne("group_id", "\Falconer\Acl\Model\Groups", "id", array('alias' => 'Groups'));
        $this->hasMany("resource_id", "\Falconer\Acl\Model\Resources", "resource_id", array('alias' => 'Resources'));
    }
    
    public function getStruct() {
        ;
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