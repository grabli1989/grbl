<?php

namespace Phone\Code;

use User\Interfaces\ConfirmationCodeGeneratorInterface;

class ConfirmationCodeGenerator implements ConfirmationCodeGeneratorInterface
{
    public function make(): string
    {
        return $this->randomNumber();
    }

    /**
     * @return string
     */
    private function randomNumber(): string
    {
        $result = '';

        for ($i = 0; $i < self::LENGTH; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }
}
