<?php

class TableTest extends PHPUnit_Framework_TestCase
{

    private function _getDefinition()
    {
        return require('default_table.php');
    }

    public function testTableInstance()
    {
        $table = new Falconer\Base\Table();

        $this->assertInstanceOf('Falconer\\Base\\Table', $table);
    }

    public function testTableResultVertical()
    {
        $table = new Falconer\Base\Table();

        $lista = $this->_getDefinition();

        $result = $table->render('Normal Table', $lista);

        $this->assertInternalType('string', $result);
    }

    public function testTableResultVertical()
    {
        $table = new Falconer\Base\Table();

        $lista = $this->_getDefinition();

        $result = $table->renderHorizontal('Horizontal Table', reset($lista));

        $this->assertInternalType('string', $result);
    }
}
