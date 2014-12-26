<?php
namespace Falconer\Base\Model;

use Falconer\Base\Model;
use Falconer\Helper\Definition\DefinitionHelperFactory;

/**
* RememberTokens
* Stores the remember me tokens
*/
class RememberTokens extends Model
{
    public function initialize()
    {
        $this->belongsTo('user_id', 'Falconer\Base\Models\Users', 'id', array(
            'alias' => 'user'
        ));
    }

    public function getSource()
    {
        return 'remember_tokens';
    }

    public function getStruct()
    {
        return $this->struct = array(
            'password_changes' => DefinitionHelperFactory::get('Relation'),
            'id' => DefinitionHelperFactory::get('PrimaryColumn'),
            'user_id' => DefinitionHelperFactory::get('HiddenColumn'),
            'token' =>  DefinitionHelperFactory::get('TextColumn'),
            'user_agent' =>  DefinitionHelperFactory::get('TextColumn'),
            'created_at' => DefinitionHelperFactory::get('DateTimeColumn'),
        );
    }

    /**
    * Before create the user assign a password
    */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->createdAt = time();
    }


}
