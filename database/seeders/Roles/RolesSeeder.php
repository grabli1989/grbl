<?php

namespace Database\Seeders\Roles;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\RolesInterface;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    use WithoutModelEvents;

    public const GUARD = 'sanctum';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesPermissions = [
            RolesInterface::ROLES['SUPER_ADMIN'] => [],
            RolesInterface::ROLES['ADMIN'] => [
                PermissionsInterface::PERMISSIONS['APPROVAL_AD'],
                PermissionsInterface::PERMISSIONS['REJECT_AD'],
                PermissionsInterface::PERMISSIONS['DELETE_AD'],
                PermissionsInterface::PERMISSIONS['DISABLE_AD'],
                PermissionsInterface::PERMISSIONS['UPDATE_AD'],
                PermissionsInterface::PERMISSIONS['CREATE_CATEGORY'],
                PermissionsInterface::PERMISSIONS['UPDATE_CATEGORY'],
                PermissionsInterface::PERMISSIONS['REMOVE_CATEGORY'],
                PermissionsInterface::PERMISSIONS['PUT_SETTING'],
                PermissionsInterface::PERMISSIONS['DROP_SETTING'],
                PermissionsInterface::PERMISSIONS['CREATE_PERMISSION'],
                PermissionsInterface::PERMISSIONS['UPDATE_PERMISSION'],
                PermissionsInterface::PERMISSIONS['REMOVE_PERMISSION'],
                PermissionsInterface::PERMISSIONS['ASSIGN_PERMISSION'],
                PermissionsInterface::PERMISSIONS['CREATE_ROLE'],
                PermissionsInterface::PERMISSIONS['UPDATE_ROLE'],
                PermissionsInterface::PERMISSIONS['REMOVE_ROLE'],
                PermissionsInterface::PERMISSIONS['ASSIGN_ROLE'],
            ],
            RolesInterface::ROLES['MODERATOR'] => [
                PermissionsInterface::PERMISSIONS['APPROVAL_AD'],
                PermissionsInterface::PERMISSIONS['REJECT_AD'],
                PermissionsInterface::PERMISSIONS['DELETE_AD'],
                PermissionsInterface::PERMISSIONS['DISABLE_AD'],
                PermissionsInterface::PERMISSIONS['UPDATE_AD'],
                PermissionsInterface::PERMISSIONS['CREATE_CATEGORY'],
                PermissionsInterface::PERMISSIONS['UPDATE_CATEGORY'],
                PermissionsInterface::PERMISSIONS['REMOVE_CATEGORY'],
                PermissionsInterface::PERMISSIONS['PUT_SETTING'],
                PermissionsInterface::PERMISSIONS['DROP_SETTING'],
            ],

        ];

        foreach ($rolesPermissions as $role => $permissions) {
            /** @var Role $role */
            $role = Role::findOrCreate($role, self::GUARD);
            $role->syncPermissions($permissions);
        }
    }
}
