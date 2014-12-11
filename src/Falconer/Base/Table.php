<?php

namespace Falconer\Base;

use Falconer\Exception\Template\TemplateDoesNotExist;
use Falconer\Helper\Core;

class Table
{

    public $defaultTemplate;

    public function __construct($args = array())
    {
        $this->init($args);
    }

    public function init($args)
    {
        $this->defaultTemplate = implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), 'Table', 'Template', 'default.phtml']);
        if (array_key_exists('template', $args))
        {
            if (file_exists($args['template']))
            {
                $this->defaultTemplate = $args['template'];
            }
            else
            {
                throw new TemplateDoesNotExist;
            }
        }
    }

    protected function buildThead($cols)
    {
        $thead = '<thead>'
                . '<tr>';

        foreach ($cols as $col)
        {
            $thead .= '<th>' . Core::label($col) . '</th>';
        }
        $thead .= '</tr>'
                . '</thead>';

        return $thead;
    }

    protected function buildTfoot()
    {
        /**
         * @todo
         */
    }

    protected function buildTbody()
    {
        
    }

    /**
     * Cria uma tabela
     *
     * @param <type> $caption Caption da tabela
     * @param <type> $lista Lista de resultados
     * @param <type> $pager Paginador, normalmente o resultado de Falconer\Base\Pager::render
     * @param array $options Opções para a coluna opções, um array de callbacks que recebem a linha atual
     * @param array $formatters Formatadores de coluna, no formato coluna => callback que recebe a linha atual *E A LISTA*
     * @param array $provider Provedores de dados, no formato coluna => callback que recebe a linha atual E A LISTA e retorna a mesma linha com os dados adicionais
     * @param array $skip Colunas ignoradas na exibição
     * @param string $indexCheck Índice que será usado como valor num checkbox que será colocado em cada linha. O nome é o próprio índice.
     * @param string $indexTrClass Índice da coluna que será adicionada como classe ao TR atual
     * @param string $subTable Array que indica quais colunas serão exibidas na tabela (as colunas id e options são exibidas por padrão). Caso este array seja não-nulo, adiciona uma lista com uma subtabela abaixo da linha
     * @return string Tabela
     */
    public function render($caption, $lista, $pager = null, array $options = array(), array $formatters = array(), array $provider = array(), array $skip = array(), $indexCheck = null, $indexTrClass = null, array $subTable = array())
    {
//        if ($lista instanceof PDOStatement)
//        {
//            $lista = $lista->fetchAll();
//        }
//
//        if ($provider)
//        {
//            $provider = current($provider);
//            $p_func = reset($provider);
//
//            if (isset($provider[1]))
//            {
//                $p_params = $provider[1];
//            }
//            else
//            {
//                $p_params = array();
//            }
//
//            $lista = call_user_func_array($p_func, array($lista, $p_params));
//        }
//
//        $tableDef = [
//            'thead' => $this->buildThead(array_keys(reset($lista))),
//            'tbody' => $this->buildTbody($lista, $formatters, $options),
//            'tfooter' => $this->buildTfoot($pager),
//        ];
    }

}
