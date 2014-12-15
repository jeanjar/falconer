<?php

include '../../../vendor/autoload.php';

$def = require_once('default_def.php');

$options = $input = [];

$form = new Falconer\Base\Form($def, $options, $input);

echo $form->render();
