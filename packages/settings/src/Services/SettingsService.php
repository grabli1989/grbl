<?php

namespace Settings\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Realty\Interfaces\SettingsServiceInterface;
use Settings\Exceptions\SettingsException;
use Settings\Interfaces\HasSettingsInterface;
use Settings\Models\Setting;

class SettingsService implements SettingsServiceInterface
{
    /**
     * @param  string  $property
     * @param  mixed|null  $default
     * @return array|string|bool|object|null
     */
    public function get(string $property, mixed $default = null): array|string|bool|object|null
    {
        if (! $setting = $this->getSetting($property)) {
            return $default;
        }

        return $setting->value;
    }

    /**
     * @param  string  $property
     * @param  string  $value
     * @return void
     *
     * @throws SettingsException
     */
    public function put(string $property, string $value): void
    {
        if ($setting = $this->getSetting($property)) {
            $setting->value = $value;
            $setting->save();
        } else {
            $this->create($property, $value);
        }
    }

    /**
     * @param  string  $property
     * @return void
     *
     * @throws SettingsException
     */
    public function drop(string $property): void
    {
        $setting = $this->assertExists($property);
        $setting->delete();
    }

    /**
     * @param  string  $property
     * @param  string  $value
     * @return void
     *
     * @throws SettingsException
     */
    public function create(string $property, string $value): void
    {
        if ($this->has($property)) {
            throw SettingsException::settingAlreadyExists($property);
        }
        Setting::create(['property' => $property, 'value' => $value]);
    }

    /**
     * @param  HasSettingsInterface  $model
     * @param  string  $property
     * @return void
     *
     * @throws SettingsException
     */
    public function assignSetting(HasSettingsInterface $model, string $property): void
    {
        $setting = $this->assertExists($property);

        if ($this->modelHasProperty($model, $property)) {
            throw SettingsException::settingAlreadyAttached($model, $property);
        }
        $model->assignSetting($setting);
    }

    /**
     * @param  HasSettingsInterface  $model
     * @param  string  $property
     * @return void
     *
     * @throws SettingsException
     */
    public function revokeSetting(HasSettingsInterface $model, string $property): void
    {
        $setting = $this->assertExists($property);

        if (! $this->modelHasProperty($model, $property)) {
            throw SettingsException::settingAlreadyDetached($model, $property);
        }
        $model->revokeSetting($setting);
    }

    /**
     * @param  string  $property
     * @return Setting|null
     */
    private function getSetting(string $property): Setting|null
    {
        return Setting::where('property', $property)->first();
    }

    /**
     * @param  string  $property
     * @return bool
     */
    public function has(string $property): bool
    {
        return (bool) $this->getSetting($property);
    }

    /**
     * @param  HasSettingsInterface  $model
     * @param  string  $property
     * @return bool
     */
    public function modelHasProperty(HasSettingsInterface $model, string $property): bool
    {
        return (bool) $model->getSettingByName($property);
    }

    /**
     * @param  string  $property
     * @return Setting|Builder|Model
     *
     * @throws SettingsException
     */
    public function assertExists(string $property): Setting|Builder|Model
    {
        if (! $setting = $this->getSetting($property)) {
            throw SettingsException::settingNotFound($property);
        }

        return $setting;
    }
}
