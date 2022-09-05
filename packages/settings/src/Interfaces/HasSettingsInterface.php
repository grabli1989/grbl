<?php

namespace Settings\Interfaces;

use Settings\Models\Setting;

interface HasSettingsInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function settings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany;

    /**
     * @param  Setting  $setting
     * @return void
     */
    public function assignSetting(Setting $setting): void;

    /**
     * @param  Setting  $setting
     * @return void
     */
    public function revokeSetting(Setting $setting): void;

    /**
     * @param  string  $name
     * @return Setting|null
     */
    public function getSettingByName(string $name): ?Setting;

    /**
     * @return array
     */
    public function getSettingsArray(): array;
}
