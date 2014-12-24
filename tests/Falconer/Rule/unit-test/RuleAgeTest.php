<?php

class RuleAgeTest extends PHPUnit_Framework_TestCase
{

    public function _getDefinition()
    {
        return include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'default_def.php');
    }

    public function testAgeMustBeFalseUnderAge()
    {
        $def = $this->_getDefinition();
        $definition = new \Falconer\Definition($def, 'item');

        $ruleQueryResult = $definition->query(\Falconer\Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        $data = [
            'birth_date' => '13/06/1998'
        ];

        $this->assertFalse($rules->invoke($data));
    }

    public function testAgeMustBeTrue()
    {
        $def = $this->_getDefinition();
        $definition = new \Falconer\Definition($def, 'item');

        $ruleQueryResult = $definition->query(\Falconer\Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        $data = [
            'birth_date' => '29/08/1993'
        ];

        $this->assertTrue($rules->invoke($data));
    }

}
