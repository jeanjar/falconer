<?php

namespace Falconer\Acl\Model;

use Phalcon\Mvc\Model\Validator\InclusionIn,
Phalcon\Mvc\Model\Validator\Uniqueness,
Phalcon\Mvc\Model\Relation;


class Users extends \Falconer\Base\Model
{

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public static $genderMap = array(
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female'
    );

    public function getSource()
    {
        return "users";
    }

    public function initialize()
    {
        $this->skipAttributesOnCreate(array('created_at'));
        $this->useDynamicUpdate(true);

        $this->hasOne("group_id", "\Falconer\Acl\Model\Groups", "id", array('alias' => 'Groups'));
        $this->hasMany("id", "\Falconer\Acl\Model\UsersResources", "user_id", array('alias' => 'Resources', 'foreignKey' => array(
            'action' => Relation::ACTION_CASCADE
        )));
    }

    public function getStruct() {
        return $this->struct = array(
            'users' => array(
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
            'nome' => array(
                'type' => \Falconer\Definition::TYPE_COLUMN,
                \Falconer\Definition::TYPE_WIDGET => array(
                    'type' => 'text'
                ),
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

    public function getGroups($params=null)
    {
        return $this->getRelated('Groups', $params);
    }

    public function getResources($params=null)
    {
        return $this->getRelated('Resources', $params);
    }

    public function validation()
    {
        $this->validate(new Uniqueness(
            array(
                "field" => 'username',
                'message' => 'The username must be unique'
            )
        ));

        $this->validate(new Uniqueness(
            array(
                "field" => 'email',
                'message' => 'The email must be unique'
            )
        ));

        $this->validate(new InclusionIn(
            array(
                "field" => "gender",
                "domain" => array(self::GENDER_MALE, self::GENDER_FEMALE)
            )
        ));

        if ($this->validationHasFailed() == true) {
            return false;
        }

    }

}
