<?php

namespace Falconer\Acl\Model;

class UsersResources extends \Falconer\Base\Model
{
    public function getSource() {
        return 'users_resource';
    }
    
    public function initialize()
    {
        $this->belongsTo("resource_id", "\Falconer\Acl\Model\Resources", "id", array('alias' => 'Resources'));
        $this->belongsTo("user_id", "\Falconer\Acl\Model\Users", "id", array('alias' => 'Users'));
    }
    
    public function getStruct() {
        ;
    }
    
}