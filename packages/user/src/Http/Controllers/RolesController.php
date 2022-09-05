<?php

namespace User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use User\Http\Requests\Roles\CreateRoleRequest;
use User\Http\Requests\Roles\RemoveRoleRequest;
use User\Http\Requests\Roles\UpdateRoleRequest;
use User\Http\Requests\Roles\UserAssignRoleRequest;
use User\Http\Requests\Roles\UserDetachRoleRequest;
use User\Models\User;

class RolesController
{
    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $roles = [];
        foreach (Role::all() as $role) {
            $roles[$role->id] = [
                'id' => $role->id,
                'name' => $role->name,
                'guardName' => $role->guard_name,
            ];
        }

        return response()->json(['status' => 'success', 'roles' => $roles]);
    }

    /**
     * @param  CreateRoleRequest  $request
     * @return JsonResponse
     */
    public function create(CreateRoleRequest $request): JsonResponse
    {
        $name = $request->get('name');
        /** @var Role $role */
        $role = Role::create(['name' => $name]);

        return response()->json(['status' => 'success', 'message' => 'Role created successfully', 'id' => $role->id], 201);
    }

    /**
     * @param  UpdateRoleRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request): JsonResponse
    {
        /** @var Role $role */
        $role = Role::findById($request->get('id'));
        $role->update(['name' => $request->get('name')]);

        return response()->json(['status' => 'success', 'message' => 'Role updated successfully'], 201);
    }

    /**
     * @param  RemoveRoleRequest  $request
     * @return JsonResponse
     */
    public function remove(RemoveRoleRequest $request): JsonResponse
    {
        Role::findById($request->get('id'))->delete();

        return response()->json(['status' => 'success', 'message' => 'Role removed successfully'], 201);
    }

    /**
     * @param  UserAssignRoleRequest  $request
     * @return JsonResponse
     */
    public function userAssign(UserAssignRoleRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::find($request->get('userId'));
        $role = Role::findById($request->get('roleId'));
        $user->assignRole($role);

        return response()->json(['status' => 'success', 'message' => 'Assign successfully'], 201);
    }

    /**
     * @param  UserDetachRoleRequest  $request
     * @return JsonResponse
     */
    public function userDetach(UserDetachRoleRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::find($request->get('userId'));
        $role = Role::findById($request->get('roleId'));
        $user->removeRole($role);

        return response()->json(['status' => 'success', 'message' => 'Detach successfully'], 201);
    }
}
