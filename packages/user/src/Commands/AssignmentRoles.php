<?php

namespace User\Commands;

class AssignmentRoles
{
    /**
     * @param  array  $roles
     */
    public function __construct(public readonly array $roles)
    {
    }
}
