<?php

namespace Falconer\Acl;

interface AclInterface
{
    public function isPrivate($controllerName);

    public function isAllowed($group, $controller, $action);

    public function getAcl();

    public function getPermissions($group);

    public function getResources();

    public function getActionDescription($action);

    public function setPrivateResources($resources);

    public function setActionDescriptions($actions);
}
