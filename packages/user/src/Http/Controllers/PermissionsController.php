<?php

namespace User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use User\Http\Requests\Permissions\CreatePermissionRequest;
use User\Http\Requests\Permissions\PermissionAssignRoleRequest;
use User\Http\Requests\Permissions\PermissionRemoveRoleRequest;
use User\Http\Requests\Permissions\RemovePermissionRequest;
use User\Http\Requests\Permissions\UpdatePermissionRequest;
use User\Http\Requests\Permissions\UserGivePermissionToRequest;
use User\Http\Requests\Permissions\UserRevokePermissionToRequest;
use User\Models\User;

class PermissionsController
{
    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            $permissions[$permission->id] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'guardName' => $permission->guard_name,
            ];
        }

        return response()->json(['status' => 'success', 'permissions' => $permissions]);
    }

    /**
     * @param  CreatePermissionRequest  $request
     * @return JsonResponse
     */
    public function create(CreatePermissionRequest $request): JsonResponse
    {
        $name = $request->get('name');
        /** @var Permission $permission */
        $permission = Permission::create(['name' => $name]);

        return response()->json(['status' => 'success', 'message' => 'Permission created successfully', 'id' => $permission->id], 201);
    }

    /**
     * @param  UpdatePermissionRequest  $request
     * @return JsonResponse
     */
    public function update(UpdatePermissionRequest $request): JsonResponse
    {
        /** @var Permission $permission */
        $permission = Permission::findById($request->get('id'));
        $permission->update(['name' => $request->get('name')]);

        return response()->json(['status' => 'success', 'message' => 'Permission updated successfully'], 201);
    }

    /**
     * @param  RemovePermissionRequest  $request
     * @return JsonResponse
     */
    public function remove(RemovePermissionRequest $request): JsonResponse
    {
        Permission::findById($request->get('id'))->delete();

        return response()->json(['status' => 'success', 'message' => 'Permission removed successfully'], 201);
    }

    /**
     * @param  PermissionAssignRoleRequest  $request
     * @return JsonResponse
     */
    public function assignRole(PermissionAssignRoleRequest $request): JsonResponse
    {
        $role = Role::findById($request->get('roleId'));
        /** @var Permission $permission */
        $permission = Permission::findById($request->get('permissionId'));
        $permission->assignRole($role);

        return response()->json(['status' => 'success', 'message' => 'Permission assign role successfully'], 201);
    }

    /**
     * @param  UserGivePermissionToRequest  $request
     * @return JsonResponse
     */
    public function userGivePermissionTo(UserGivePermissionToRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::find($request->get('userId'));
        $permission = Permission::findById($request->get('permissionId'));
        $user->givePermissionTo($permission);

        return response()->json(['status' => 'success', 'message' => 'User gives permission successfully'], 201);
    }

    /**
     * @param  PermissionRemoveRoleRequest  $request
     * @return JsonResponse
     */
    public function removeRole(PermissionRemoveRoleRequest $request): JsonResponse
    {
        $role = Role::findById($request->get('roleId'));
        /** @var Permission $permission */
        $permission = Permission::findById($request->get('permissionId'));
        $permission->removeRole($role);

        return response()->json(['status' => 'success', 'message' => 'Permission removed role successfully'], 201);
    }

    /**
     * @param  UserRevokePermissionToRequest  $request
     * @return JsonResponse
     */
    public function userRevokePermissionTo(UserRevokePermissionToRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::find($request->get('userId'));
        $permission = Permission::findById($request->get('permissionId'));
        $user->revokePermissionTo($permission);

        return response()->json(['status' => 'success', 'message' => 'User revoked permission successfully'], 201);
    }
}
