<?php

include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'boot.php');

$table = new Falconer\Base\Table();

$lista = require_once('default_table.php');

echo $table->render('Normal Table', $lista);
echo '<hr/>';
echo $table->renderHorizontal('Horizontal Table', reset($lista));
