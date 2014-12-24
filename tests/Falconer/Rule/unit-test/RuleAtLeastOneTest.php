<?php

class RuleAtLeastOneTest extends PHPUnit_Framework_TestCase
{
    public function _getDefinition()
    {
        return include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'default_def.php');
    }

    public function testAtLeastOneMustBeFalse()
    {
        $def = $this->_getDefinition();
        $definition = new \Falconer\Definition($def, 'form_telephone');

        $ruleQueryResult = $definition->query(\Falconer\Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        $data = [
            'name' => 'Stofo'
        ];

        $this->assertFalse($rules->invoke($data));
    }

    public function testAtLeastOneMustBeTrue()
    {
        $def = $this->_getDefinition();
        $definition = new \Falconer\Definition($def, 'form_telephone');

        $ruleQueryResult = $definition->query(\Falconer\Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        $data = [
            'fax' => '88495546',
        ];

        $this->assertTrue($rules->invoke($data));
    }
}
