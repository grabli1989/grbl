<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use User\Director\DirectorTestUsers;
use User\Models\User;
use User\User\UserBuilder;

trait WithAuthTrait
{
    use RefreshDatabase;

    /**
     * @return User
     */
    protected function getSuperAdminTestUser(): User
    {
        $builder = new UserBuilder();
        $director = new DirectorTestUsers();
        $director->setBuilder($builder);
        $director->buildSuperAdminTestUser();

        $user = $builder->getUser();
        $user->save();

        return $user;
    }

    public function getUsualTestUser(): User
    {
        $builder = new UserBuilder();
        $director = new DirectorTestUsers();
        $director->setBuilder($builder);
        $director->buildUsualTestUser();

        $user = $builder->getUser();
        $user->save();

        return $user;
    }

    /**
     * @param  array  $abilities
     * @return string
     */
    protected function getToken(User $user, string $name = 'test-token', array $abilities = ['assertIsConfirmed']): string
    {
        return $user->createToken('test-token', $abilities)->plainTextToken;
    }
}
