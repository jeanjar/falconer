<?php

class FormTest extends PHPUnit_Framework_TestCase
{

    private function _getDefinition()
    {
        return $def = [
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

    }

    public function testFormInstance()
    {
        $def = $this->_getDefinition();
        $options = $input = [];

        $form = new Falconer\Base\Form($def, $options, $input);

        $this->assertInstanceOf('Falconer\\Base\\Form', $form);
    }

    public function testFormReturn()
    {
        $def = $this->_getDefinition();
        $options = $input = [];

        $form = new Falconer\Base\Form($def, $options, $input);

        // workaround for http request uri
        $_SERVER['REQUEST_URI'] = '';

        $this->assertInternalType('string', $form->render());
    }
}
