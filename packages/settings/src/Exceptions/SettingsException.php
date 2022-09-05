<?php

namespace Settings\Exceptions;

use Settings\Interfaces\HasSettingsInterface;

class SettingsException extends \Exception
{
    public const CODES = [
        0 => 'SETTING_NOT_FOUND',
        1 => 'SETTING_ALREADY_ATTACHED',
        2 => 'SETTING_ALREADY_DETACHED',
        3 => 'SETTING_ALREADY_EXISTS',

    ];

    /**
     * @param  string  $property
     * @return SettingsException
     */
    public static function settingNotFound(string $property): SettingsException
    {
        return new self("Setting where property $property not found", 0);
    }

    /**
     * @param  HasSettingsInterface  $model
     * @param  string  $property
     * @return SettingsException
     */
    public static function settingAlreadyAttached(HasSettingsInterface $model, string $property): SettingsException
    {
        return new self("Setting $property already attached with ".class_basename($model)." id: $model->id", 1);
    }

    /**
     * @param  HasSettingsInterface  $model
     * @param  string  $property
     * @return SettingsException
     */
    public static function settingAlreadyDetached(HasSettingsInterface $model, string $property): SettingsException
    {
        return new self("Setting $property already detached with ".class_basename($model)." id: $model->id", 2);
    }

    /**
     * @param  string  $property
     * @return SettingsException
     */
    public static function settingAlreadyExists(string $property): SettingsException
    {
        return new self("Setting $property already exists", 3);
    }
}
