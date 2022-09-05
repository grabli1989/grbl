<?php

namespace Realty\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Realty\Models\AdTranslation
 *
 * @property int $id
 * @property int $ad_id
 * @property string $locale
 * @property string $caption
 * @property string $description
 * @property string $city
 * @method static \Illuminate\Database\Eloquent\Builder|AdTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdTranslation whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdTranslation whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdTranslation whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdTranslation whereLocale($value)
 * @mixin \Eloquent
 */
class AdTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['caption', 'description', 'city'];
}
