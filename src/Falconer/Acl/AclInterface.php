<?php

namespace Falconer\Acl;

use Falconer\Base\Model\Groups;

interface AclInterface
{
    public function isPrivate($controllerName);

    public function isAllowed($group, $controller, $action);

    public function getAcl();

    public function getPermissions(Groups $group);

    public function getResources();

    public function getActionDescription($action);

    public function setPrivateResources($resources);

    public function setActionDescriptions($actions);
}
