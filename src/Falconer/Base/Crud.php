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
    public $operation;

    /**
     *
     * @var string Página
     */
    public $page;

    /**
     *
     * @var string Limite por página
     */
    public $limit;

    /**
     *
     * @var string identifier do registro sendo crudado
     */
    public $identifier;

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
    public $relation_identifier = null;

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

        $this->relation = $this->operation = $this->page = $this->limit =
        $this->identifier = $this->input = $this->primary = $this->itemWhere =
        $this->item = $this->extraCaption = $this->tableInBox = $this->tableInBoxTitle = null;

        $this->searchFormEnabled = true;
    }

    private function _setRelation()
    {
        if (!$this->relation)
        {
            if(isset($get['r']) && is_object($get['r']))
            {
                $this->relation = $get['r'];
            } else {
                $this->relation = \Falconer\Helper\Core::coalesce(\Falconer\Helper\Core::filter($parameters, 'r'), \Falconer\Helper\Core::filter($get, 'r'));
            }
        }

    }

    private function _setDatastore($datastore_name)
    {
        $dependency_injector = \Phalcon\DI::getDefault();

        if (!($datastore_name instanceof \Falconer\Base\Model))
        {
            $datastore = $this->datastore = new $datastore_name($dependency_injector);
        } else
        {
            $datastore = $this->datastore = $datastore_name;
        }

        return $datastore;
    }

    private function _getDatastoreDefinition()
    {
        if (!$this->operation)
        {
            $this->operation = $datastore::OPERATION_DEFAULT;
        }

        $definition = $this->datastore->getDefinition($this->operation);

        return $definition;
    }

    private function _setDependencyAttr($get, $post, $definition)
    {
        if (!$this->primary)
        {
            $this->primary = $primary = $definition->query(\Falconer\Definition::TYPE_COLUMN)->byKey('primary')->fetch(\Falconer\Definition::MODE_SINGLE);
        }

        if (!$this->identifier)
        {
            $this->identifier = \Falconer\Helper\Core::filter($get, $this->primary);
        }

        if (!$this->index)
        {
            $this->index = $this->relation;
        }

        if ($this->identifier)
        {

        } else {
            $this->input = $post;
        }

    }

    public function configureCrud($get, $post, $reset = true)
    {
        if ($reset)
        {
            $this->resetCrud();
        }

        $parameters = $this->urlParams;

        $this->_setRelation();

        if (!$this->operation)
        {
            $this->operation = \Falconer\Helper\Core::filter($get, 'op');
        }

        if (!$this->relation)
        {
            throw new \Falconer\Exception\Base\CrudWithoutRelation;
        }

        $datastore_name = $this->relation;

        $datastore = $this->setDatastore($datastore_name);

        if (!($this->datastore instanceof \Falconer\Base\Model))
        {
            throw new \Falconer\Exception\Base\IncorrectDatastoreInheritance;
        }

        $definition = $this->_getDatastoreDefinition();

        $this->_setDependencyAttr($get, $post, $definition);
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

    private function _getTransactionDatastore()
    {
        $transactionManager = new TransactionManager();
        $transaction = $transactionManager->get();
        $this->datastore->setTransaction($transaction);

        return $transaction;
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
            $this->_processCreatePost($definition);
        }

        $def = $definition->query(\Falconer\Definition::TYPE_WIDGET)->fetch();

        $options = array('controller' => $this, 'legend' => $legend);
        if ($this->options)
        {
            $options = array_merge($options, $this->options);
        }

        $form = new $this->formClass($def, $options, $this->input);

        $template = $this->_getTemplate();

        return $form->render($template);
    }

    private function _processCreatePost($definition)
    {
        if($this->create_action instanceof Closure)
        {
            $this->create_action->__invoke();
        }
        else
        {
            $rules = $this->_getRulesFromDefition($definition);

            if ($rules->invoke($this->input))
            {
                if ($update)
                {
                    if (!$this->itemWhere)
                    {
                        throw new \Falconer\Exception\Crud\UnspecifiedItem;
                    }
                    $sql = $this->datastore->createQuery(array('cols' => $this->input, 'where' => $this->itemWhere));
                    $msg = $this->msgUpdate ? $this->msgUpdate : 'O registro foi atualizado.';
                    return [$sql, $msg];
                } else {
                    $sql = $this->datastore->createQuery($this->input);
                    $msg = $this->msgCreate ? $this->msgCreate : 'O registro foi criado.';
                    return [$sql, $msg];
                }

                $identifier = $this->_saveCreate($sql);

                $this->_flashRedirect($msg);

                return $identifier;
            } else {
                $messages = \Falconer\Rule\MessagePrinter::event($rules->getMessages(), C::$labels);
                $this->flash->error($messages);
            }
        }

    }

    private function _saveCreate($sql)
    {
        $transaction = $this->_getTransactionDatastore();
        try
        {
            $identifier = $this->datastore->hydrateResultOfExec($sql, $this->input);

            $transaction->commit();

            return (int) $identifier;
        } catch (\Phalcon\Mvc\Model\Transaction\Failed $exception){
            $transaction->rollback();
            $this->flash->error($exception->getMessage());
        }

    }

    private function _flashRedirect($msg)
    {
        if ($this->flashEnabled)
        {
            $this->flash->success($msg);
        }
        if ($this->redirect)
        {
            return $this->response->redirect($this->redirectLink);
        }

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
            $this->_processDeletePost();
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

    private function _processDeletePost()
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

            $this->_peformDelete();
        }

    }

    private function _peformDelete()
    {
        $query = $this->datastore->createQuery($this->itemWhere);

        $transaction = $this->_getTransactionDatastore();
        try
        {
            $this->datastore->hydrateResultOfExec($query, array($this->primary => $this->identifier));
            $transaction->commit();

            $this->_flashRedirect($this->msgDelete);
        } catch (Exception $exception)
        {
            $transaction->rollBack();
            $this->flash->error($exception->getMessage());
        }

    }

}
