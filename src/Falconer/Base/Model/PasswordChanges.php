<?php
namespace Falconer\Base\Model;

use Falconer\Base\Model;
use Falconer\Helper\Definition\DefinitionHelperFactory;

/**
* PasswordChanges
* Register when a user changes his/her password
*/
class PasswordChanges extends Model
{
    public function initialize()
    {
        $this->belongsTo('user_id', 'Falconer\Base\Model\Users', 'id', array(
            'alias' => 'user'
        ));
    }

    public function getSource()
    {
        return "password_changes";
    }

    public function getStruct()
    {
        return $this->struct = array(
            'password_changes' => DefinitionHelperFactory::get('Relation'),
            'id' => DefinitionHelperFactory::get('PrimaryColumn'),
            'user_id' => DefinitionHelperFactory::get('HiddenColumn'),
            'ip_address' => DefinitionHelperFactory::get('TextColumn'),
            'user_agent' =>  DefinitionHelperFactory::get('TextColumn'),
            'created_at' =>  DefinitionHelperFactory::get('DateTimeColumn'),
        );
    }
}
