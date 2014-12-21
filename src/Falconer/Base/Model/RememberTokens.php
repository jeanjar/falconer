<?php
namespace Falconer\Base\Model;

use Phalcon\Mvc\Model;

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
            'remember_tokens' => array(
                'type' => \Falconer\Definition::TYPE_RELATION,
                'statement_type' => \Falconer\Definition::STATEMENT_SELECT,
                \Falconer\Definition::OPERATION => array(
                    'read' => array(),
                    'item' => array(),
                    'create' => array(
                        'statement_type' => \Falconer\Definition::STATEMENT_INSERT,
                    ),
                    'update' => array(
                        'statement_type' => \Falconer\Definition::STATEMENT_UPDATE,
                    ),
                    'delete' => array(
                        'statement_type' => \Falconer\Definition::STATEMENT_DELETE,
                    ),
                ),
            ),
            //
            'id' => array(
                'type' => \Falconer\Definition::TYPE_COLUMN,
                'primary' => true,
                'hide' => true,
                \Falconer\Definition::OPERATION => array(
                    'read' => array(),
                    'item' => array(),
                    'create' => array(),
                    'update' => array(),
                    'delete' => array(),
                ),
            ),
            //
            'user_id' => array(
                'type' => \Falconer\Definition::TYPE_COLUMN,
                \Falconer\Definition::OPERATION => array(
                    'read' => array(),
                    'item' => array(),
                    'create' => array(),
                    'update' => array(),
                    'delete' => array(),
                ),
            ),
            //
            'token' => array(
                'type' => \Falconer\Definition::TYPE_COLUMN,
                \Falconer\Definition::OPERATION => array(
                    'read' => array(),
                    'item' => array(),
                    'create' => array(),
                    'update' => array(),
                    'delete' => array(),
                ),
            ),
            //
            'user_agent' => array(
                'type' => \Falconer\Definition::TYPE_COLUMN,
                \Falconer\Definition::OPERATION => array(
                    'read' => array(),
                    'item' => array(),
                    'create' => array(),
                    'update' => array(),
                    'delete' => array(),
                ),
            ),
            //
            'created_at' => array(
                'type' => \Falconer\Definition::TYPE_COLUMN,
                \Falconer\Definition::OPERATION => array(
                    'read' => array(),
                    'item' => array(),
                    'create' => array(),
                    'update' => array(),
                    'delete' => array(),
                ),
            ),
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
