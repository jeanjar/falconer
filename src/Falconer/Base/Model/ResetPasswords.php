<?php

namespace Falconer\Base\Model;

use Phalcon\Mvc\Model;

class ResetPasswords extends Model
{

    public function initialize()
    {
        $this->belongsTo('user_id', 'Falconer\Base\Model\Users', 'id', array(
            'alias' => 'user'
        ));
    }

    public function getSource()
    {
        return "reset_passwords";
    }

    public function getStruct()
    {
        return $this->struct = array(

        );
    }

    /**
    * Before create the user assign a password
    */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->created_at = time();

        // Generate a random confirmation code
        $this->verification_code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

        // Set status to non-confirmed
        $this->reset = 'N';
    }

    /**
    * Sets the timestamp before update the confirmation
    */
    public function beforeValidationOnUpdate()
    {
        // Timestamp the confirmaton
        $this->modified_at = time();
    }
}
