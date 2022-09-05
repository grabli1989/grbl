<?php

namespace User\Resources\Roles;

use JetBrains\PhpStorm\ArrayShape;
use Spatie\Permission\Models\Role;
use User\Interfaces\RoleResourceInterface;

class RoleResource implements RoleResourceInterface
{
    /**
     * @param  Role  $role
     * @return array
     */
    #[ArrayShape(['id' => 'int', 'name' => 'string', 'guardName' => 'string', 'createdAt' => 'string', 'updatedAt' => 'string'])]
    public function array(Role $role): array
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'guardName' => $role->guard_name,
            'createdAt' => $role->created_at,
            'updatedAt' => $role->updated_at,
        ];
    }
}
