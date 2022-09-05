<?php

namespace User\Resources\User;

use Illuminate\Support\Collection;
use Realty\Interfaces\MediaServiceInterface;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use User\Interfaces\UserResourceInterface;
use User\Models\User;
use User\Resources\Permissions\PermissionResource;
use User\Resources\Roles\RoleResource;

class UserResource implements UserResourceInterface
{
    public function __construct(
        private readonly RoleResource $roleResource,
        private readonly PermissionResource $permissionResource,
        private readonly MediaServiceInterface $mediaService
    ) {
    }

    /**
     * @param  User  $user
     * @return array
     */
    public function array(User $user): array
    {
        $roles = $this->roles($user);
        $permissions = $this->permissions($user);

        return [
            'id' => $user->id,
            'firstName' => $user->info->first_name,
            'lastName' => $user->info->last_name,
            'middleName' => $user->info->middle_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'isConfirmed' => $user->isConfirmed(),
            'createdAt' => $user->created_at,
            'updatedAt' => $user->updated_at,
            'images' => $this->mediaService->prepareMedias($user->getMedia()),
            'settings' => $user->getSettingsArray(),
            'guardName' => $user->guardName(),
            'roles' => $roles,
            'permissions' => $permissions,

        ];
    }

    /**
     * @param  User  $user
     * @return Collection
     */
    private function roles(User $user): Collection
    {
        return $user->getRoles()->map(function (Role $role) {
            return $this->roleResource->array($role);
        });
    }

    /**
     * @param  User  $user
     * @return Collection
     */
    private function permissions(User $user): Collection
    {
        /** @var Collection $permissions */
        $permissions = $user->getPermissions();

        if ($user->roles) {
            $permissions = $permissions->merge($user->getPermissionsViaRoles());
        }

        return $permissions->map(function (Permission $permission) {
            return $this->permissionResource->array($permission);
        });
    }
}
