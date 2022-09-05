<?php

namespace Markable\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Markable\Models\View
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $user_agent_identifier
 * @property \Illuminate\Support\Carbon $view_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|View newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|View newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|View query()
 * @method static \Illuminate\Database\Eloquent\Builder|View whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|View whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|View whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|View whereUserAgentIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|View whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|View whereViewDate($value)
 * @mixin \Eloquent
 */
class View extends Model
{
    protected $fillable = [
        'user_id', 'user_agent_identifier', 'view_date',
    ];

    protected $casts = [
        'view_date' => 'datetime',
    ];
}
