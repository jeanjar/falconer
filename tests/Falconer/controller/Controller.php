<?php

include dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'boot.php';

class Controller extends \Falconer\Base\Crud
{
    public function createAction()
    {
        $get = [
            'r' => '\\Falconer\\Acl\\Model\\Users',
            'op' => 'create'
        ];

        $post = $_POST;

        $this->configureCrud($get, $post);

        return $this->_create();
    }
}

$controller = new Controller();
echo $controller->createAction();
