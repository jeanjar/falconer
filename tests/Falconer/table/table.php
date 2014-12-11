<?php

include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'boot.php');

$table = new Falconer\Base\Table();

$lista = [
    0 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
    1 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
    3 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
    4 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
    5 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
    6 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
    7 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
];

echo $table->render('Normal Table', $lista);
echo '<hr/>';
echo $table->renderHorizontal('Horizontal Table', reset($lista));