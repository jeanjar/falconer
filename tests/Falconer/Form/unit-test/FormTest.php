<?php

class FormTest extends PHPUnit_Framework_TestCase
{

    private function _getDefinition()
    {
        return require(__DIR__ . DIRECTORY_SEPARATOR . '../default_def.php');
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
