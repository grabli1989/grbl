<?php

namespace Realty\Interfaces;

use Settings\Interfaces\HasSettingsInterface;

interface SettingsServiceInterface
{
    /**
     * @param  string  $property
     * @param  mixed|null  $default
     * @return array|string|bool|object|null
     */
    public function get(string $property, mixed $default = null): array|string|bool|object|null;

    /**
     * @param  string  $property
     * @param  string  $value
     * @return void
     */
    public function put(string $property, string $value): void;

    /**
     * @param  string  $property
     * @return void
     */
    public function drop(string $property): void;

    /**
     * @param  HasSettingsInterface  $model
     * @param  string  $property
     * @return bool
     */
    public function modelHasProperty(HasSettingsInterface $model, string $property): bool;

    /**
     * @param  string  $property
     * @return bool
     */
    public function has(string $property): bool;

    /**
     * @param  HasSettingsInterface  $model
     * @param  string  $property
     * @return void
     */
    public function assignSetting(HasSettingsInterface $model, string $property): void;

    /**
     * @param  HasSettingsInterface  $model
     * @param  string  $property
     * @return void
     */
    public function revokeSetting(HasSettingsInterface $model, string $property): void;
}
