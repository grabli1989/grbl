<?php

namespace Markable\Models;

use Maize\Markable\Mark;

/**
 * Markable\Models\PhoneView
 *
 * @property int $id
 * @property int $user_id
 * @property string $markable_type
 * @property int $markable_id
 * @property string|null $value
 * @property mixed|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $markable
 * @property-read \User\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView whereMarkableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView whereMarkableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneView whereValue($value)
 * @mixin \Eloquent
 */
class PhoneView extends Mark
{
    /**
     * @return string
     */
    public static function markableRelationName(): string
    {
        return 'phoneviewers';
    }

    /**
     * @return string
     */
    public static function markRelationName(): string
    {
        return 'phoneviews';
    }
}
