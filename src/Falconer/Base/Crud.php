<?php

namespace Falconer\Base;

abstract class Crud extends \Phalcon\Mvc\Controller
{
    
    public $searchFormEnabled = true;
    public $columnsTableVisible = array();
    public $showOptions = true;
    public $showAllOptions = true;
    public $flashEnabled = true;
    public $formLegend = false;
    public $formClass = 'Cdc_Form';
    public $showRelationResults = false;
    public $urlParams;

    /**
     * Lista de itens resultado de Read
     * @var type array
     */
    public $readList = array();

    /**
     *
     * @var string Nome do model
     */
    public $relation;

    /**
     *
     * @var string Operation
     */
    public $op;

    /**
     *
     * @var string Página
     */
    public $p;

    /**
     *
     * @var string Limite por página
     */
    public $l;

    /**
     *
     * @var string Id do registro sendo crudado
     */
    public $id;

    /**
     *
     * @var string Nome da coluna primary deste model
     */
    public $primary;

    /**
     *
     * @var array Where() de filtragem para listas
     */
    public $filters = array();

    /**
     *
     * @var array order() para listas
     */
    public $order = array();

    /**
     *
     * @var boolean Redirecionar após create/update/delete?
     */
    public $redirect = true;

    /**
     *
     * @var array Opções personalizadas
     */
    public $options = null;
    public $relation_id = null;

    /**
     *
     * @var array Dados sendo crudados. Interno
     */
    public $input = array();
    public $itemWhere;
    public $searchFormTemplate;
    public $formTemplate;
    public $filterData = array();
    public $item;
    public $createButtonEnabled = true;
    public $readButtonEnabled = true;
    public $redirectUpdate;
    public $readHorizontal = false;
    public $modalConfirmation = false;
    public $resetUrl;
    public $linkRead;
    public $linkCreate;
    public $callbacks = array();
    public $extraCaption;
    public $msgCreate;
    public $msgUpdate;
    public $msgDelete;
    public $tableInBox;
    public $tableInBoxTitle;
    
    public function resetCrud()
    {
        $this->filters = $this->filterData = $this->order = $this->callbacks = array();

        $this->relation = $this->op = $this->p = $this->l = $this->id = $this->input = $this->primary = $this->itemWhere = $this->item = $this->extraCaption = $this->tableInBox = $this->tableInBoxTitle = null;

        $this->searchFormEnabled = true;
    }
    
    public function configureCrud($get, $post, $reset = true)
    {
        if ($reset)
        {
            $this->resetCrud();
        }

        $parameters = $this->urlParams;

        if (!$this->relation)
        {
            if(isset($get['r']) && is_object($get['r']))
            {
                $this->relation = $get['r'];
            } else {
                $this->relation = \Falconer\Helper\Core::coalesce(\Falconer\Helper\Core::filter($parameters, 'r'), \Falconer\Helper\Core::filter($get, 'r'));
            }
        }

        if (!$this->op)
        {
            $this->op = \Falconer\Helper\Core::filter($get, 'op');
        }
        
        if (!$this->relation)
        {
            throw new \Falconer\Exception\Base\CrudWithoutRelation;
        }
        
        $datastore_name = $this->relation;
        
        $di = \Phalcon\DI::getDefault();
        
        if (!($datastore_name instanceof \Falconer\Base\Model))
        {
            $datastore = $this->datastore = new $datastore_name($di);
        } else
        {
            $datastore = $this->datastore = $datastore_name;
        }
        if (!($this->datastore instanceof \Falconer\Base\Model))
        {
            throw new \Falconer\Exception\Base\IncorrectDatastoreInheritance;
        }
        
        if (!$this->op)
        {
            $this->op = $datastore::OPERATION_DEFAULT;
        }

        $definition = $this->datastore->getDefinition($this->op);
        
        if (!$this->primary)
        {
            $this->primary = $primary = $definition->query(\Falconer\Definition::TYPE_COLUMN)->byKey('primary')->fetch(\Falconer\Definition::MODE_SINGLE);
        }
        
        if (!$this->id)
        {
            $this->id = \Falconer\Helper\Core::filter($get, $this->primary);
        }
        
        if (!$this->index)
        {
            $this->index = $this->relation;
        }
        
        if ($this->id)
        {
            
        } else {
            $this->input = $post;
        }
    }
    
    public function _read()
    {
        
    }
    
    public function _create($update = false)
    {
        
    }
    
    public function _update()
    {
        return $this->_create(true);
    }
    
    public function _delete()
    {
        
    }
    
}