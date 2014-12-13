<?php

class TableTest extends PHPUnit_Framework_TestCase
{

    private function _getDefinition()
    {
        return [
            0 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
            1 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
            3 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
            4 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
            5 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
            6 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
            7 => ['id' => 1, 'title' => 'hi', 'some_key' => 'Lorem Ipsum'],
        ];

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
