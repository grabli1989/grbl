<?php

namespace Realty\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Realty\Models\QuestionTranslation
 *
 * @property int $id
 * @property int $question_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTranslation whereQuestionId($value)
 * @mixin \Eloquent
 */
class QuestionTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];
}
