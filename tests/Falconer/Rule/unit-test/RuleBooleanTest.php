<?php

class RuleBooleanTest extends PHPUnit_Framework_TestCase
{

    public function _getDefinition()
    {
        return include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'default_def.php');
    }

    public function testBooleanMustBeTrue()
    {
        $def = $this->_getDefinition();
        $definition = new \Falconer\Definition($def, 'item');

        $ruleQueryResult = $definition->query(\Falconer\Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        $data = [
            'active' => true
        ];

        $this->assertTrue($rules->invoke($data));
    }

    public function testBooleanMustBeTrueWithString()
    {
        $def = $this->_getDefinition();
        $definition = new \Falconer\Definition($def, 'item');

        $ruleQueryResult = $definition->query(\Falconer\Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        $data = [
            'active' => 'yes'
        ];

        $this->assertTrue($rules->invoke($data));
    }

    public function testBooleanMustBeTrueWithNull()
    {
        $def = $this->_getDefinition();
        $definition = new \Falconer\Definition($def, 'item');

        $ruleQueryResult = $definition->query(\Falconer\Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        $data = [
            'active' => null
        ];

        $this->assertTrue($rules->invoke($data));
    }

}
