<?php

namespace Falconer\Base;

use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

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

    /**
     *  @var closures
     */

    public $create_action;
    public $delete_action;
    public $read_action;

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

        $dependency_injector = \Phalcon\DI::getDefault();

        if (!($datastore_name instanceof \Falconer\Base\Model))
        {
            $datastore = $this->datastore = new $datastore_name($dependency_injector);
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

    private function _setFormLegend($update) {
        if ($update)
        {
            $legend = \Falconer\Helper\I18n::translate('Editar item');
        } else
        {
            $legend = \Falconer\Helper\I18n::translate('Novo item');
        }

        if ($this->formLegend)
        {
            $legend = $this->formLegend;
        }

        return $legend;
    }

    private function _setPageTitle($op) {
        $this->pageTitle = $this->pageTitle or \Falconer\Helper\Core::label($this->relation . $op);
    }

    private function _getRulesFromDefition($definition) {
        $ruleQueryResult = $definition->query(Cdc_Definition::TYPE_RULE)->fetch();
        $rules = new \Falconer\Rule($ruleQueryResult);

        return $definition;
    }

    private function _updateData()
    {
        if (!$this->itemWhere)
        {
            throw new \Falconer\Exception\Crud\UnspecifiedItem;
        }
        $sql = $this->datastore->createQuery(array('cols' => $this->input, 'where' => $this->itemWhere));
        $msg = $this->msgUpdate ? $this->msgUpdate : 'O registro foi atualizado.';
        return [$sql, $msg];
    }

    private function _createData()
    {
        $sql = $this->datastore->createQuery($this->input);
        $msg = $this->msgCreate ? $this->msgCreate : 'O registro foi criado.';
        return [$sql, $msg];
    }

    private function _getTransactionDatastore()
    {
        $transactionManager = new TransactionManager();
        $transaction = $transactionManager->get();
        $this->datastore->setTransaction($transaction);

        return $transaction;
    }

    private function _getFieldsFromDefinition($definition)
    {
        return $def = $definition->query(\Falconer\Definition::TYPE_WIDGET)->fetch();
    }

    private function _getFormOptions($legend)
    {
        $options = array('controller' => $this, 'legend' => $legend);
        if ($this->options)
        {
            $options = array_merge($options, $this->options);
        }

        return $options;
    }

    private function _getTemplate()
    {
        if ($this->formTemplate)
        {
            $template = $this->getTemplate($this->formTemplate);
        } else
        {
            $template = null;
        }

        return $template;
    }

    public function _create($update = false)
    {
        $request = new \Phalcon\Http\Request();

        $legend = $this->_setFormLegend($update);

        $this->_setPageTitle('_create');

        $definition = $this->datastore->getDefinition();

        if($request->isPost() === true)
        {
            if($this->create_action instanceof Closure)
            {
                $this->create_action->__invoke();
            }
            else if ($request->isPost() === true)
            {
                $rules = $this->_getRulesFromDefition($definition);

                if ($rules->invoke($this->input))
                {
                    if ($update)
                    {
                        list($sql, $msg) = $this->_updateData();
                    } else
                    {
                        list($sql, $msg) = $this->_createData();
                    }

                    $transaction = $this->_getTransactionDatastore();
                    try
                    {
                        $id = $this->datastore->hydrateResultOfExec($sql, $this->input);

                        $transaction->commit();
                        if ($this->flashEnabled)
                        {
                            $this->flash->success($msg);
                        }
                        if ($this->redirect)
                        {
                            return $this->response->redirect($this->redirectUpdate);
                        }
                        return (int) $id;
                    } catch (\Phalcon\Mvc\Model\Transaction\Failed $exception){
                        $transaction->rollback();
                        $this->flash->error($exception->getMessage());
                    }
                } else {
                    $messages = \Falconer\Rule\MessagePrinter::event($rules->getMessages(), C::$labels);
                    $this->flash->error($messages);
                }
            }
        }


        $def = $this->_getFieldsFromDefinition($definition);

        $options = $this->_getFormOptions($legend);

        $form = new $this->formClass($def, $options, $this->input);

        $template = $this->_getTemplate();

        return $form->render($template);
    }

    public function _update()
    {
        return $this->_create(true);
    }

    public function _delete()
    {
        $request = new \Phalcon\Http\Request();
        $this->_setPageTitle('_delete');

        if($request->isPost() === true)
        {
            if($this->delete_action instanceof Closure)
            {
                $this->delete_action->__invoke();
            }
            else
            {
                $primary = $this->primary;
                if (!$this->itemWhere)
                {
                    throw new \Falconer\Exception\Crud\UnspecifiedItem;
                }
                $query = $this->datastore->createQuery($this->itemWhere);

                $transaction = $this->_getTransactionDatastore();
                try
                {
                    $this->datastore->hydrateResultOfExec($query, array($this->primary => $this->id));
                    $this->handleUploads($this->id, null, 'delete');
                    $transaction->commit();
                    flash($this->msgDelete ? $this->msgDelete : 'O registro foi excluído.');

                    return $this->response->redirect($this->redirectDelete);
                } catch (Exception $exception)
                {
                    $transaction->rollBack();
                    $this->flash->error($exception->getMessage());
                }
            }

        }

        $def = array();

        $options = array(
            '_delete' => true,
            'submit_text' => $this->submit_text,
        );

        $form = new $this->formClass($def, $options, $this->input);

        $template = $this->_getTemplate();

        return $this->pageDescription . $form->render($template);
    }

}
