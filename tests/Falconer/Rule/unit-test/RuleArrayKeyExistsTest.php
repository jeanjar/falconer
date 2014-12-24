<?php

class RuleArrayKeyExists extends PHPUnit_Framework_TestCase
{
    public function _getDefinition()
    {
        return include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'default_def.php');
    }

    public function testArrayKeyExistsMustBeFalse()
    {
        $def = $this->_getDefinition();
        $definition = new \Falconer\Definition($def, 'item');

        $ruleQueryResult = $definition->query(\Falconer\Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        $data = [
            'sex' => 'femaler',
        ];

        $this->assertFalse($rules->invoke($data));
    }

    public function testArrayKeyExistsMustBeTrue()
    {
        $def = $this->_getDefinition();
        $definition = new \Falconer\Definition($def, 'item');

        $ruleQueryResult = $definition->query(\Falconer\Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        $data = [
            'sex' => 'female',
        ];

        $this->assertTrue($rules->invoke($data));
    }
}
