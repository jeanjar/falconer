<?php

return array(
    'name' => array(
        'type' => \Falconer\Definition::TYPE_COLUMN,
        \Falconer\Definition::TYPE_WIDGET => array(
            'type' => 'text'
        ),
        \Falconer\Definition::OPERATION => array(
            'item' => array(),
        ),
    ),
    //
    'email' => array(
        'type' => \Falconer\Definition::TYPE_COLUMN,
        \Falconer\Definition::TYPE_WIDGET => array(
            'type' => 'text'
        ),
        \Falconer\Definition::OPERATION => array(
            'item' => array(),
        ),
    ),
    //
    'password' => array(
        'type' => \Falconer\Definition::TYPE_COLUMN,
        \Falconer\Definition::TYPE_WIDGET => array(
            'type' => 'password'
        ),
        \Falconer\Definition::OPERATION => array(
            'item' => array(),
        ),
    ),
    'birth_date' => array(
        'type' => \Falconer\Definition::TYPE_COLUMN,
        \Falconer\Definition::TYPE_WIDGET => array(
            'type' => 'text'
        ),
        \Falconer\Definition::OPERATION => array(
            'item' => array(),
        ),
        \Falconer\Definition::TYPE_RULE => array(
            array('\Falconer\Rule\Age', array(18, 'd/m/Y')),
        ),
    ),
    'sex' => array(
        'type' => \Falconer\Definition::TYPE_COLUMN,
        \Falconer\Definition::TYPE_WIDGET => array(
            'type' => 'select',
            'options' => array(
                'female' => 'Felame',
                'male' => 'Male'
            ),
        ),
        \Falconer\Definition::OPERATION => array(
            'item' => array(),
        ),
        \Falconer\Definition::TYPE_RULE => array(
            array('\Falconer\Rule\ArrayKeyExists', array(array(
                'female' => 'Felame',
                'male' => 'Male'
            ))),
        ),
    ),
    'telephone' => array(
        'type' => \Falconer\Definition::TYPE_COLUMN,
        \Falconer\Definition::TYPE_WIDGET => array(
            'type' => 'text',
        ),
        \Falconer\Definition::OPERATION => array(
            'form_telephone' => array(),
        ),
        \Falconer\Definition::TYPE_RULE => array(
            array('\Falconer\Rule\AtLeastOne', array(array('telephone', 'fax'))),
        ),
    ),
    'fax' => array(
        'type' => \Falconer\Definition::TYPE_COLUMN,
        \Falconer\Definition::TYPE_WIDGET => array(
            'type' => 'text'
        ),
        \Falconer\Definition::OPERATION => array(
            'form_telephone' => array(),
        ),
    ),
    'active' => array(
        'type' => \Falconer\Definition::TYPE_COLUMN,
        \Falconer\Definition::TYPE_WIDGET => array(
            'type' => 'text'
        ),
        \Falconer\Definition::OPERATION => array(
            'item' => array(),
        ),
        \Falconer\Definition::TYPE_RULE => array(
            array('\Falconer\Rule\Boolean', array()),
        ),
    ),
);
