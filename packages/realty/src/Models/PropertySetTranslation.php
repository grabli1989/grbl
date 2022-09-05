<?php

namespace Realty\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Realty\Models\PropertySetTranslation
 *
 * @property int $id
 * @property int $property_set_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySetTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySetTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySetTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySetTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySetTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySetTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySetTranslation wherePropertySetId($value)
 * @mixin \Eloquent
 */
class PropertySetTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];
}
