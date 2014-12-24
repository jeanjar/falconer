<?php

include '../../../../vendor/autoload.php';

$def = require_once(__DIR__ . '/../default_def.php');

$options = $input = [];

$form = new Falconer\Base\Form($def, $options, $input);

echo $form->render();
