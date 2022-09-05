<?php

namespace User\User;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use User\Models\User;
use User\Models\UserInfo;

class UserBuilder
{
    protected User $user;

    protected UserInfo $info;

    /**
     * UserBuilder constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    private function reset(): void
    {
        $this->user = new User();
    }

    /**
     * @return void
     */
    public function createInfo(): void
    {
        /** @var UserInfo $info */
        $info = $this->user->info()->create();
        $this->info = $info;
    }

    /**
     * @param  string  $firstName
     * @return void
     */
    public function produceFirstName(string $firstName): void
    {
        $this->user->info->first_name = $firstName;
    }

    /**
     * @param  string  $lastName
     * @return void
     */
    public function produceLastName(string $lastName): void
    {
        $this->user->info->last_name = $lastName;
    }

    /**
     * @param  string  $middleName
     * @return void
     */
    public function produceMiddleName(string $middleName): void
    {
        $this->user->info->middle_name = $middleName;
    }

    /**
     * @param  string  $email
     * @return void
     */
    public function produceEmail(string $email): void
    {
        $this->user->email = $email;
    }

    /**
     * @param  string  $phone
     * @return void
     */
    public function producePhone(string $phone): void
    {
        $this->user->phone = $phone;
    }

    /**
     * @param  string  $code
     * @return void
     */
    public function producePhoneConfirmationCode(string $code): void
    {
        $this->user->phone_confirmation_code = $code;
    }

    /**
     * @param  bool  $isConfirmed
     * @return void
     */
    public function produceIsConfirmed(bool $isConfirmed): void
    {
        $this->user->is_confirmed = $isConfirmed;
    }

    /**
     * @param  Carbon  $date
     * @return void
     */
    public function producePhoneVerifiedAt(Carbon $date): void
    {
        $this->user->phone_verified_at = $date;
    }

    /**
     * @param  Carbon  $date
     * @return void
     */
    public function produceEmailVerifiedAt(Carbon $date): void
    {
        $this->user->email_verified_at = $date;
    }

    /**
     * @param  string  $password
     * @return void
     */
    public function producePassword(string $password): void
    {
        $this->user->password = $password;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return UserInfo
     */
    public function getInfo(): UserInfo
    {
        return $this->info;
    }

    /**
     * @param  array  $array
     * @return void
     */
    public function produceRoles(array $array): void
    {
        $role = Role::findByName('super-admin', 'sanctum');
        $this->user->guard(['sanctum'])->assignRole($role);
    }
}
