<?php

include '../../../vendor/autoload.php';

$def = [
    'type_primary' => [
        Falconer\Definition::TYPE_WIDGET => [
            'widget' => 'hidden',
        ],
    ],
    'type_text' => [
        Falconer\Definition::TYPE_WIDGET => [
            'widget' => 'text',
            'attributes' => [
                'class' => 'some-class',
                'placeholder' => 'Some text',
            ],
        ],
    ],
    'type_select' => [
        Falconer\Definition::TYPE_WIDGET => [
            'widget' => 'select',
            'options' => [1 => 'Option 1', 2 => 'Option 2', 3 => 'Option 3'],
        ],
    ],
];

$options = $input = [];

$form = new Falconer\Base\Form($def, $options, $input);

echo $form->render();
