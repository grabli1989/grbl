<?php

namespace Admin\Commands;

class UpdateUser
{
    /**
     * @param  int  $id
     * @param  string  $firstName
     * @param  string  $lastName
     * @param  string  $middleName
     * @param  string  $email
     */
    public function __construct(
        public readonly int $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $middleName,
        public readonly string $email
    ) {
    }
}
