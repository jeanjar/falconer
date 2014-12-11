<?php

include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'boot.php');

$table = new Falconer\Base\Table(['template' => 'tchu']);

$table->render();