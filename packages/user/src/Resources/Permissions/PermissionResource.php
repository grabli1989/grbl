<?php

namespace User\Resources\Permissions;

use JetBrains\PhpStorm\ArrayShape;
use Spatie\Permission\Models\Permission;
use User\Interfaces\PermissionResourceInterface;

class PermissionResource implements PermissionResourceInterface
{
    /**
     * @param  Permission  $permission
     * @return array
     */
    #[ArrayShape(['id' => 'int', 'name' => 'string', 'guardName' => 'string', 'createdAt' => 'string', 'updatedAt' => 'string'])]
    public function array(Permission $permission): array
    {
        return [
            'id' => $permission->id,
            'name' => $permission->name,
            'guardName' => $permission->guard_name,
            'createdAt' => $permission->created_at,
            'updatedAt' => $permission->updated_at,
        ];
    }
}
