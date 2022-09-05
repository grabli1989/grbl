<?php

namespace Realty\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Realty\Models\PropertyTranslation
 *
 * @property int $id
 * @property int $property_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyTranslation wherePropertyId($value)
 * @mixin \Eloquent
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyTranslation whereValue($value)
 */
class PropertyTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'value'];
}
