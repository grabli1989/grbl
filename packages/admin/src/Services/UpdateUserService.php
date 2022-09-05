<?php

namespace Admin\Services;

use Admin\Commands\UpdateUser;
use User\Models\User;

class UpdateUserService
{
    /**
     * @param  UpdateUser  $command
     * @return void
     */
    public function handle(UpdateUser $command): void
    {
        $user = User::query()->where('id', $command->id)->with('info')->first();
        $user->update(['email' => $command->email]);
        $user->info()->update([
            'first_name' => $command->firstName,
            'last_name' => $command->lastName,
            'middle_name' => $command->middleName,
        ]);
    }
}
