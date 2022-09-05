<?php

namespace User\Interfaces;

use User\Models\User;

interface UserResourceInterface
{
    public function array(User $user): array;
}
