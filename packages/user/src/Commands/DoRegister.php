<?php

namespace User\Commands;

class DoRegister
{
    private string $phone;

    private string $password;

    /**
     * @param  string  $phone
     * @param  string  $password
     */
    public function __construct(string $phone, string $password)
    {
        $this->phone = $phone;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
