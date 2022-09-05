<?php

namespace Database\Seeders\Roles;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Realty\Interfaces\PermissionsInterface;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
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
        foreach (PermissionsInterface::PERMISSIONS as $permission) {
            Permission::findOrCreate($permission, self::GUARD);
        }
    }
}
