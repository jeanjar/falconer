<?php

namespace Falconer\Acl\Model;

class GroupsResources extends \Falconer\Base\Model
{
    public function getSource()
    {
        return 'groups_resources';
    }
    
    public function initialize()
    {
        $this->belongsTo("resource_id", "\Falconer\Acl\Model\Resources", "id", array('alias' => 'Resources'));
        $this->belongsTo("group_id", "\Falconer\Acl\Model\Groups", "id", array('alias' => 'Groups'));
    }
    
    public function getStruct() {
        ;
    }
}
