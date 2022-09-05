<?php

namespace Realty\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Realty\Models\AdHasProperty
 *
 * @property int $property_id
 * @property int $ad_id
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Realty\Models\Ad $ad
 * @property-read \Realty\Models\Property $property
 * @method static \Illuminate\Database\Eloquent\Builder|AdHasProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdHasProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdHasProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdHasProperty whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdHasProperty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdHasProperty wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdHasProperty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdHasProperty whereValue($value)
 * @mixin \Eloquent
 */
class AdHasProperty extends Model
{
    protected $fillable = [
        'ad_id',
        'property_id',
        'value',
    ];

    /**
     * @return BelongsTo
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * @return BelongsTo
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
