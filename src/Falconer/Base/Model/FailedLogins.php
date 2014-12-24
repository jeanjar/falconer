<?php

namespace Falconer\Base\Model;

use Phalcon\Mvc\Model;

class FailedLogins extends Model
{
    public function initialize()
    {
        $this->belongsTo('user_id', 'Falconer\Base\Model\Users', 'id', array(
            'alias' => 'user'
        ));
    }

    public function getSource()
    {
        return "failed_logins";
    }

    public function getStruct()
    {
        return $this->struct = array(
            'failed_logins' => DefinitionHelperFactory::get('Relation'),
            'id' => DefinitionHelperFactory::get('PrimaryColumn'),
            'user_id' => DefinitionHelperFactory::get('HiddenColumn'),
            'ip_address' => DefinitionHelperFactory::get('TextColumn'),
            'attempted' => DefinitionHelperFactory::get('HiddenColumn'),
        );
    }
}
