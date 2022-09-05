<?php

namespace User\Interfaces;

interface ConfirmationCodeGeneratorInterface
{
    public const LENGTH = 6;

    /**
     * @return string
     */
    public function make(): string;
}
