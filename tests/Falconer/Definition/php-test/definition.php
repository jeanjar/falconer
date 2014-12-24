<?php

include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'boot.php');

$user = new \Falconer\Acl\Model\Users($di);
$definition = $user->getDefinition('create');
$def = $definition->query(\Falconer\Definition::TYPE_WIDGET)->fetch();

var_dump($def);die;
