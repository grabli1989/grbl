<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Database\Seeders\Roles\PermissionsSeeder;
use Database\Seeders\Roles\RolesSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use User\Models\User;

class UserSeeder extends Seeder
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
        $modules = app()->make('modules');
        $password = $modules->get('user.admin.password');

        $this->call([
            PermissionsSeeder::class,
            RolesSeeder::class,
        ]);

        if (! $user = User::where('email', 'super.admin@realty.com')->first()) {
            /** @var User $user */
            $user = User::create([
                'name' => 'Super Admin',
                'email' => 'super.admin@realty.com',
                'phone' => '380987654321',
                'phone_confirmation_code' => '0000',
                'is_confirmed' => true,
                'phone_verified_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'password' => \Hash::make($password),

            ]);
        }

        $role = Role::findByName('super-admin', self::GUARD);
        $user->guard([self::GUARD])->assignRole($role);
    }
}
