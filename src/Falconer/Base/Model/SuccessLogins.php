<?php

namespace Falconer\Base\Model;

use Falconer\Base\Model;
use Falconer\Helper\Definition\DefinitionHelperFactory;


/**
* SuccessLogins
* This model registers successfull logins registered users have made
*/
class SuccessLogins extends Model
{
    public function initialize()
    {
        $this->belongsTo('user_id', 'Falconer\Base\Model\Users', 'id', array(
            'alias' => 'user'
        ));
    }

    public function getSource()
    {
        return "success_logins";
    }

    public function getStruct()
    {
        return $this->struct = array(
            'success_logins' => DefinitionHelperFactory::get('Relation'),
            'id' => DefinitionHelperFactory::get('PrimaryColumn'),
            'user_id' => DefinitionHelperFactory::get('HiddenColumn'),
            'ip_address' => DefinitionHelperFactory::get('TextColumn'),
            'user_agent' =>  DefinitionHelperFactory::get('TextColumn'),
        );
    }
}
