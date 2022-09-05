<?php

namespace Realty\Console\Commands;

use Illuminate\Console\Command;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\RolesInterface;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SyncRoles extends Command
{
    public const GUARD = 'sanctum';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for sync roles in configuration and db';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        foreach (PermissionsInterface::PERMISSIONS as $permission) {
            Permission::findOrCreate($permission, self::GUARD);
        }

        foreach (RolesInterface::ROLES_PERMISSIONS as $role => $permissions) {
            /** @var Role $role */
            $role = Role::findOrCreate($role, self::GUARD);
            $role->syncPermissions($permissions);
        }

        return 0;
    }
}
