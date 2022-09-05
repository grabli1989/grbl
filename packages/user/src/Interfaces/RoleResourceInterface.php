<?php

namespace User\Interfaces;

use Spatie\Permission\Models\Role;

interface RoleResourceInterface
{
    public function array(Role $role): array;
}
