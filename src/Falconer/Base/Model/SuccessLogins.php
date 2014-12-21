<?php

namespace Falconer\Base\Model;

use Phalcon\Mvc\Model;

/**
* SuccessLogins
* This model registers successfull logins registered users have made
*/
class SuccessLogins extends Model
{
    public function getSource()
    {
        return "success_logins";
    }
}
