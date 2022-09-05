<?php

namespace User\Interfaces;

use Spatie\Permission\Models\Permission;

interface PermissionResourceInterface
{
    public function array(Permission $permission): array;
}
