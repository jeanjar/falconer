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
            'failed_logins' => array(
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
            'ip_address' => array(
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
            'attempted' => array(
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
