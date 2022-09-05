<?php

namespace User\Services;

use Illuminate\Support\Facades\Hash;
use User\Commands\DoRegister;
use User\Interfaces\ConfirmationCodeGeneratorInterface;
use User\Models\User;

class DoRegisterService
{
    private ConfirmationCodeGeneratorInterface $confirmationCodeGenerator;

    /**
     * @param  ConfirmationCodeGeneratorInterface  $confirmationCodeGenerator
     */
    public function __construct(ConfirmationCodeGeneratorInterface $confirmationCodeGenerator)
    {
        $this->confirmationCodeGenerator = $confirmationCodeGenerator;
    }

    /**
     * @param  DoRegister  $command
     * @return void
     */
    public function handle(DoRegister $command): void
    {
        User::create([
            'phone' => $command->getPhone(),
            'password' => Hash::make($command->getPassword()),
            'phone_confirmation_code' => $this->makeConfirmationCode(),
        ])->info()->create();
    }

    /**
     * @return string
     */
    private function makeConfirmationCode(): string
    {
        return $this->confirmationCodeGenerator->make();
    }
}
