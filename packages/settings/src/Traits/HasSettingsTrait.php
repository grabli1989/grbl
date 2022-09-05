<?php

namespace Settings\Traits;

use Settings\Models\Setting;

trait HasSettingsTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function settings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->morphToMany(Setting::class, 'model', 'model_has_settings', 'model_id', 'setting_id');
    }

    /**
     * @param  Setting  $setting
     * @return void
     */
    public function assignSetting(Setting $setting): void
    {
        $this->settings()->attach($setting);
    }

    /**
     * @param  Setting  $setting
     * @return void
     */
    public function revokeSetting(Setting $setting): void
    {
        $this->settings()->detach($setting);
    }

    /**
     * @param  string  $name
     * @return Setting|null
     */
    public function getSettingByName(string $name): ?Setting
    {
        return $this->settings()->where('property', $name)->first();
    }

    /**
     * @return array
     */
    public function getSettingsArray(): array
    {
        $settings = [];
        foreach ($this->settings as $setting) {
            $settings[$setting->property] = $setting->value;
        }

        return $settings;
    }
}
