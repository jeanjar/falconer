<?php

class ResetPasswordsTest extends PHPUnit_Framework_TestCase
{

    public function _instanceModel()
    {
        $di = \Phalcon\DI::getDefault();
        $model = new \Falconer\Base\Model\ResetPasswords($di);
        return $model;
    }

    public function testDefinition()
    {
        $model = $this->_instanceModel();

        $definition = $model->getDefinition('create');

        $this->assertInstanceOf('\\Falconer\\Definition', $definition);
    }

    public function testDefinitionArray()
    {
        $model = $this->_instanceModel();

        $definition = $model->getDefinition('create');

        $this->assertInternalType('array', $definition->getDefinition());
    }

}
