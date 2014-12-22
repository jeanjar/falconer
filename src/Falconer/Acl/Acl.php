<?php

namespace Falconer\Acl;

use Phalcon\Mvc\User\Component;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Acl\Resource as AclResource;
use Falconer\Base\Model\Groups;

abstract class Acl extends Component implements AclInterface
{

    /**
    * The ACL Object
    *
    * @var \Phalcon\Acl\Adapter\Memory
    */
    private $acl;

    /**
    * The filepath of the ACL cache file from APP_DIR
    *
    * @var string
    */
    private $filePath = '/cache/acl/data.txt';

    /**
    * Define the resources. These controller => actions require authentication.
    *
    * @var array
    */
    protected $privateResources = array();

    /**
    * Human-readable descriptions of the actions used in {@see $privateResources}
    *
    * @var array
    */
    protected $actionDescriptions = array();

    public function __construct($resources = null, $actions = null, $cacheFilePath = null)
    {
        $this->setPrivateResources($resources);
        $this->setActionDescriptions($actions);

        if($cacheFilePath)
        {
            $this->filePath = $cacheFilePath;
        }
    }

    /**
    * Checks if a controller is private or not
    *
    * @param string $controllerName
    * @return boolean
    */
    public function isPrivate($controllerName)
    {
        return isset($this->privateResources[$controllerName]);
    }

    /**
    * Checks if the current group is allowed to access a resource
    *
    * @param string $group
    * @param string $controller
    * @param string $action
    * @return boolean
    */
    public function isAllowed($group, $controller, $action)
    {
        return $this->getAcl()->isAllowed($group, $controller, $action);
    }

    /**
    * Returns the ACL list
    *
    * @return Phalcon\Acl\Adapter\Memory
    */
    public function getAcl()
    {
        // Check if the ACL is already created
        if (is_object($this->acl)) {
            return $this->acl;
        }

        // Check if the ACL is in APC
        if (function_exists('apc_fetch')) {
            $acl = apc_fetch('falconer-acl');
            if (is_object($acl)) {
                $this->acl = $acl;
                return $acl;
            }
        }

        // Check if the ACL is already generated
        if (!file_exists(APP_DIR . $this->filePath)) {
            $this->acl = $this->rebuild();
            return $this->acl;
        }

        // Get the ACL from the data file
        $data = file_get_contents(APP_DIR . $this->filePath);
        $this->acl = unserialize($data);

        // Store the ACL in APC
        if (function_exists('apc_store')) {
            apc_store('falconer-acl', $this->acl);
        }

        return $this->acl;
    }

    /**
    * Returns the permissions assigned to a group
    *
    * @param groups $group
    * @return array
    */
    public function getPermissions(Groups $group)
    {
        $permissions = array();
        foreach ($group->getPermissions() as $permission) {
            $permissions[$permission->resource . '.' . $permission->action] = true;
        }
        return $permissions;
    }

    /**
    * Returns all the resoruces and their actions available in the application
    *
    * @return array
    */
    public function getResources()
    {
        return $this->privateResources;
    }

    /**
    * Returns the action description according to its simplified name
    *
    * @param string $action
    * @return $action
    */
    public function getActionDescription($action)
    {
        if (isset($this->actionDescriptions[$action])) {
            return $this->actionDescriptions[$action];
        } else {
            return $action;
        }
    }

    /**
    * Rebuilds the access list into a file
    *
    * @return \Phalcon\Acl\Adapter\Memory
    */
    public function rebuild()
    {
        $acl = new AclMemory();

        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        // Register roles
        $groups = Groups::find('active = true');

        foreach ($groups as $group) {
            $acl->addRole(new AclRole($group->name));
        }

        foreach ($this->privateResources as $resource => $actions) {
            $acl->addResource(new AclResource($resource), $actions);
        }

        // Grant acess to private area to role Users
        foreach ($groups as $group) {

            // Grant permissions in "permissions" model
            foreach ($group->getPermissions() as $permission) {
                $acl->allow($group->name, $permission->resource, $permission->action);
            }

            // Always grant these permissions
            $acl->allow($group->name, 'users', 'changePassword');
        }

        if (touch(APP_DIR . $this->filePath) && is_writable(APP_DIR . $this->filePath)) {

            file_put_contents(APP_DIR . $this->filePath, serialize($acl));

            // Store the ACL in APC
            if (function_exists('apc_store')) {
                apc_store('falconer-acl', $acl);
            }
        } else {
            $this->flash->error(
            'The user does not have write permissions to create the ACL list at ' . APP_DIR . $this->filePath
            );
        }

        return $acl;
    }
}
