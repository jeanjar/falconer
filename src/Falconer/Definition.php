<?php

/**
 * Cdc Toolkit
 *
 * Copyright 2012 Eduardo Marinho
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * 	 http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author Eduardo Marinho
 * @package Falconer
 */

namespace Falconer;

use Falconer\Exception\Definition\MultipleRelationsFound,
    Falconer\Exception\Definition\UninitializedQuery,
    Falconer\Exception\Definition\NoOperationSpecified;

/**
 * Consulta a conjuntos de definições.
 *
 * Uma definição é um conjunto de atributos que descrevem como uma determinada
 * estrutura de dados deve se comportar em diversas situações comuns em sistemas,
 * como formulário, filtro e validação de dados, consulta em bancos de dados,
 * ou qualquer outra coisa que pareça útil e que faça sentido ser definida em
 * apenas um lugar. As constantes de tipo são apenas lembretes e facilitadores,
 * usadas internamente pelo toolkit, e não o conjunto fechado de tipos.
 *
 * Uma definição é apenas um arquivo de configuração programável.
 *
 */
class Definition
{
    /**
     * Índice para definições específicas de operação.
     */
    const OPERATION = 'operation';

    /**
     * Coluna.
     */
    const TYPE_COLUMN = 'column';

    /**
     * Relação.
     */
    const TYPE_RELATION = 'relation';

    /**
     * Anexo.
     */
    const TYPE_ATTACHMENT = 'attachment';

    /**
     * Regras de filtro e/ou validação.
     */
    const TYPE_RULE = 'rule';

    /**
     * Instruções para geração de elementos de entrada de dados.
     */
    const TYPE_WIDGET = 'widget';

    /**
     * Retornar apenas nomes das colunas.
     */
    const MODE_KEY_ONLY = 'key_only';

    /**
     * Retornar apenas o nome da primeira coluna do resultado.
     */
    const MODE_SINGLE = 'single';

    /**
     * Retornar a definição completa, após o cascateamento das definições específicas de operação.
     */
    const MODE_FULL = 'full';

    /**
     * Chave para formatters
     */
    const FORMATTER = 'formatter';

    /**
     * Chave para providers
     */
    const PROVIDER = 'provider';
    //
    const STATEMENT_SELECT = 'select';
    //
    const STATEMENT_INSERT = 'insert';
    //
    const STATEMENT_UPDATE = 'update';
    //
    const STATEMENT_DELETE = 'delete';
    //
    const RELATION_MANY_TO_MANY = 'many_to_many';
    //
    const RELATION_ONE_TO_MANY = 'one_to_many';
    //
    const RELATION_HAS_AND_BELONGS_TO = 'has_belongs_to';

    /**
     * Definição atual.
     *
     * @var array
     */
    protected $definition;

    /**
     * Operação atual.
     *
     * @var string
     */
    protected $operation;

    /**
     * Resultado de consulta.
     *
     * @var array
     */
    private $query = array();

    /**
     * Construtor.
     *
     * @param array $definition Estrutura de definição
     * @param type $operation Operação atual
     */
    public function __construct(array $definition = array(), $operation = DEFAULT_OPERATION)
    {
        $this->setDefinition($definition);
        $this->setOperation($operation);
    }
    
    /**
     * Obter a estrutura de definição atual.
     *
     * @return array Definição
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Atribui uma definição nova.
     *
     * Isto limpará a consulta atual.
     * @param array $definition
     */
    public function setDefinition(array $definition)
    {
        $this->reset();
        $this->definition = $definition;
        return $this->definition;
    }

    /**
     * Obter o nome da operação atual.
     *
     * @return string Operação
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Configura a operação.
     *
     * Isto limpará a consulta atual.
     *
     * @param type $operation
     */
    public function setOperation($operation)
    {
        $this->reset();
        $this->operation = $operation;
        return $this;
    }

    /**
     * Inicia uma consulta à definição.
     *
     * @return Cdc_Definition
     *
     * O tipo é obrigatório para normalizar as definições e simplificar o processamento.
     *
     */
    public function query(/* , .. */)
    {
        $types = func_get_args();
        $this->query = array();
        $d = $this->getDefinition();
        $type = null;
        foreach ($d as $key => $value)
        {
            if (!$this->checkValueInOperation($value))
            {
                continue;
            }

            foreach ($types as $type)
            {
                if (array_key_exists('type', $value))
                {
                    if ($value['type'] == $type)
                    {
                        $this->query[$key] = $value;
                    }
                }
                // @TODO: Melhorar esta lógica
                if (array_key_exists($type, $value))
                {
                    $this->query[$key] = $value;
                }
            }
        }
        if (($type == self::TYPE_RELATION) && (count($this->query) > 1))
        {
            throw new MultipleRelationsFound;
        }

        return $this;
    }

    /**
     * Especifica uma chave para ser utilizada na consulta.
     *
     * @param string $term Chave para a consulta.
     * @return Cdc_Definition
     */
    public function byKey($term)
    {
        foreach ((array) $this->query as $key => $value)
        {
            if (array_key_exists($term, $value[self::OPERATION][$this->getOperation()]))
            { // manter?
                if ($value[self::OPERATION][$this->getOperation()][$term] === null)
                { // remove null de dentro
                    unset($this->query[$key]);
                }
            }
            elseif (!array_key_exists($term, $value))
            { // não manter
                unset($this->query[$key]);
            }
            elseif ($value[$term] === null)
            { // remove null de fora
                unset($this->query[$key]);
            }
        }
        return $this;
    }

    /**
     * Especifica uma chave para excluir da consulta.
     *
     * O resultado incluirá todos os elementos que não possuem esta chave.
     *
     * @param string $term Chave com filtro de exclusão para a consulta.
     * @return Cdc_Definition
     */
    public function byKeyRemoval($term)
    {
        $return = array();
        foreach ((array) $this->query as $key => $value)
        {
            if (array_key_exists($term, $value[self::OPERATION][$this->getOperation()]))
            { // manter?
                if ($value[self::OPERATION][$this->getOperation()][$term] === null)
                { // remove null de dentro
                    $return[$key] = $this->query[$key];
                }
            }
            elseif (!array_key_exists($term, $value))
            { // não manter
                $return[$key] = $this->query[$key];
            }
            elseif ($value[$term] === null)
            { // remove null de fora
                $return[$key] = $this->query[$key];
            }
        }

        $this->query = $return;

        return $this;
    }

    /**
     * Verifica se existe definição para o valor na operação atual.
     *
     * A definição é obrigatória para normalizar as definições e simplificar o processamento.
     *
     * @param array $value
     * @return boolean
     * @throws NoOperationSpecified Caso a coluna não possua definições de operação.
     */
    private function checkValueInOperation($value)
    {
        if (!array_key_exists(self::OPERATION, $value))
        {
            throw new NoOperationSpecified;
        }
        return array_key_exists($this->getOperation(), $value[self::OPERATION]);
    }

    /**
     * Retorna o resultado da consulta atual.
     *
     * @param string $mode Modo de retorno (MODE_FULL ou MODE_KEY_ONLY)
     * @return array
     * @throws UninitializedQuery Caso nenhuma consulta seja especificada.
     */
    public function fetch($mode = self::MODE_FULL)
    {
        $result = $this->query;
        if (null === $result)
        {
            throw new UninitializedQuery;
        }
        if ($mode === self::MODE_FULL)
        {
            foreach ($result as $key => $value)
            {
                $result[$key] = Cdc_ArrayHelper::array_merge_recursive_distinct($value, $value[self::OPERATION][$this->getOperation()]);

                unset($result[$key][self::OPERATION]);
            }
            return $result;
        }
        elseif ($mode === self::MODE_SINGLE)
        {
            return key($result);
        }
        return array_keys($result);
    }

    /**
     * Limpa a consulta atual.
     */
    public function reset()
    {
        $this->query = null;
    }
}