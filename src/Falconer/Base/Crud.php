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
    public $formClass = '\\Falconer\\Base\\Form';
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
    public $index;
    public $pageTitle;
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
        $request = new \Phalcon\Http\Request();

        if ($this->formLegend)
        {
            $legend = $this->formLegend;
        } else
        {
            if ($update)
            {
                $legend = \Falconer\Helper\I18n::translate('Editar item');
            } else
            {
                $legend = \Falconer\Helper\I18n::translate('Novo item');
            }
        }
        $this->pageTitle = $this->pageTitle or \Falconer\Helper\Core::label($this->relation . '_create');

        $definition = $this->datastore->getDefinition();
        if ($request->isPost() == true)
        {

            $ruleQueryResult = $definition->query(Cdc_Definition::TYPE_RULE)->fetch();
            $rules = new Cdc_Rule($ruleQueryResult);
            if ($rules->invoke($this->input))
            {
                if ($update)
                {
                    if (!$this->itemWhere)
                    {
                        throw new Exception_UnspecifiedItem;
                    }
                    $sql = $this->datastore->createQuery(array('cols' => $this->input, 'where' => $this->itemWhere));
                    $msg = $this->msgUpdate ? $this->msgUpdate : 'O registro foi atualizado.';
                    $callbackIndex = Base_Crud::EVENT_AFTER_UPDATE_SUCCESS;
                } else
                {
                    $sql = $this->datastore->createQuery($this->input);
                    $msg = $this->msgCreate ? $this->msgCreate : 'O registro foi criado.';
                    $callbackIndex = Base_Crud::EVENT_AFTER_CREATE_SUCCESS;
                }

                $this->datastore->getPdo()->beginTransaction();
                try
                {
                    $id = $this->datastore->hydrateResultOfExec($sql, $this->input);
                    $this->handleUploads($id, null, $update ? 'update' : 'create');
                    $this->runCallbacks($callbackIndex, $id);

                    if ($this->showRelationResults)
                    {
                        $sql = $this->datastore_relation->generateRelationQuery($this->relation_id, $id);
                        $this->datastore_relation->hydrateResultOfExec($sql);
                    }

                    $this->datastore->getPdo()->commit();
                    if ($this->flashEnabled)
                    {
                        flash($msg);
                    }
                    if ($this->redirect)
                    {
                        $this->redirectUpdate or $this->redirectUpdate = $this->link('admin', array('r' => $this->relation), array('op' => 'update', $this->primary => $id));
                        header('Location: ' . $this->redirectUpdate);
                        die;
                    }
                    return (int) $id;
                } catch (Exception $e)
                {
                    SqlExceptionTranslator::translate($e);
//                    even\Falconer\Helper\I18n::translate($e->getMessage(), LOG_ERR);
                    $this->datastore->getPdo()->rollBack();
                }
            } else
            {
                Cdc_ConstraintMessagePrinter::event($rules->getMessages(), C::$labels);
            }
        }

        $def = $definition->query(\Falconer\Definition::TYPE_WIDGET)->fetch();
        if ($this->options)
        {
            $options = array_merge(array('controller' => $this, 'legend' => $legend), $this->options);
            $form = new $this->formClass($def, $options, $this->input);
        } else
        {

            $form = new $this->formClass($def, array('controller' => $this, 'legend' => $legend), $this->input);
        }

        if ($this->formTemplate)
        {
            $template = $this->getTemplate($this->formTemplate);
        } else
        {
            $template = null;
        }
        return $form->render($template);
    }

    public function _update()
    {
        return $this->_create(true);
    }

    public function _delete()
    {

    }

}
