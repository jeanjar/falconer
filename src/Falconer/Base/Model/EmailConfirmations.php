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
            'email_confirmations' => array(
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
            'verification_code' => array(
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
            //
            'modified_at' => array(
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
            'confirmed' => array(
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
}
