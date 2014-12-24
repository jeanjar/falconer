<?php

namespace Falconer\Base\Model;

use Phalcon\Mvc\Model;

/**
* EmailConfirmations
* Stores the reset password codes and their evolution
*/
class EmailConfirmations extends Model
{
    public function initialize()
    {
        $this->belongsTo('user_id', 'Falconer\Base\Model\Users', 'id', array(
            'alias' => 'user'
        ));
    }

    public function getSource()
    {
        return "email_confirmations";
    }

    public function getStruct()
    {
        return $this->struct = array(
            'email_confirmations' => DefinitionHelperFactory::get('Relation'),
            'id' => DefinitionHelperFactory::get('PrimaryColumn'),
            'user_id' => DefinitionHelperFactory::get('HiddenColumn'),
            'verification_code' => DefinitionHelperFactory::get('TextColumn'),
            'created_at' => DefinitionHelperFactory::get('DateTimeColumn'),
            'modified_at' => DefinitionHelperFactory::get('DateTimeColumn'),
            'confirmed' => DefinitionHelperFactory::get('BooleanColumn'),
        );
    }
}
