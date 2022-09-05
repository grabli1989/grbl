<?php

namespace User\Director;

use Carbon\Carbon;
use Realty\Interfaces\RolesInterface;
use User\User\UserBuilder;

class DirectorTestUsers
{
    private UserBuilder $builder;

    /**
     * @param  UserBuilder  $builder
     * @return void
     */
    public function setBuilder(UserBuilder $builder): void
    {
        $this->builder = $builder;
    }

    /**
     * @return void
     */
    public function buildSuperAdminTestUser(): void
    {
        $this->produceMain();
        $this->builder->produceRoles([RolesInterface::ROLES['SUPER_ADMIN']]);
        $this->produceInfo('Super', 'Admin', 'Test User');
    }

    /**
     * @return void
     */
    public function buildAdminTestUser(): void
    {
        $this->produceMain();
        $this->builder->produceRoles([RolesInterface::ROLES['ADMIN']]);
        $this->produceInfo('Simple', 'Admin', 'Test User');
    }

    /**
     * @return void
     */
    public function buildModeratorTestUser(): void
    {
        $this->produceMain();
        $this->builder->produceRoles([RolesInterface::ROLES['MODERATOR']]);
        $this->produceInfo('Simple', 'Moderator', 'Test User');
    }

    /**
     * @return void
     */
    public function buildUsualTestUser(): void
    {
        $this->produceMain();
        $this->produceInfo('Usual', 'Test', 'User');
    }

    /**
     * @return void
     */
    public function produceMain(): void
    {
        $this->builder->produceEmail('test@realty.com');
        $this->builder->producePhone('380000000000');
        $this->builder->producePhoneConfirmationCode('0000');
        $this->builder->produceIsConfirmed(true);
        $this->builder->producePhoneVerifiedAt(Carbon::now());
        $this->builder->produceEmailVerifiedAt(Carbon::now());
        $this->builder->producePassword(\Hash::make('testPassword'));
        $this->builder->getUser()->save();
    }

    /**
     * @param  string  $firstName
     * @param  string  $lastName
     * @param  string  $middleName
     * @return void
     */
    public function produceInfo(string $firstName, string $lastName, string $middleName): void
    {
        $this->builder->createInfo();
        $this->builder->produceFirstName($firstName);
        $this->builder->produceLastName($lastName);
        $this->builder->produceMiddleName($middleName);
        $this->builder->getInfo()->save();
    }
}
