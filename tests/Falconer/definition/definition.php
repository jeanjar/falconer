<?php

include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'boot.php');

$user = new \Falconer\Acl\Model\Users($di);
$definition = $user->getDefinition('create');

var_dump($definition);die;
