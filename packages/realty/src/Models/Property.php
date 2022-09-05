<?php

namespace Realty\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Realty\Models\Property
 *
 * @property int $id
 * @property int $question_id
 * @property int $position
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Realty\Models\PropertyTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\PropertyTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Property listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder|Property translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Property translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property withTranslation()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\AdHasProperty[] $adHasProperties
 * @property-read int|null $ad_has_properties_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\Ad[] $ads
 * @property-read int|null $ads_count
 * @property-read \Realty\Models\Question $question
 */
class Property extends Model implements TranslatableContract
{
    use Translatable;

    protected $fillable = [
        'question_id',
        'position',
        'slug',
    ];

    public array $translatedAttributes = ['name', 'value'];

    /**
     * @param  Question  $question
     * @return void
     */
    public function setQuestion(Question $question): void
    {
        $this->question_id = $question->id;
    }

    /**
     * @param  Ad  $ad
     * @param  string|int|bool  $value
     * @return Model|AdHasProperty
     */
    public function adValue(Ad $ad, string|int|bool $value): Model|AdHasProperty
    {
        return $this->adHasProperties()->create(['ad_id' => $ad->id, 'value' => $value]);
    }

    /**
     * @return HasMany
     */
    public function adHasProperties(): HasMany
    {
        return $this->hasMany(AdHasProperty::class, 'property_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function ads(): BelongsToMany
    {
        return $this->belongsToMany(Ad::class, 'ad_has_property', 'property_id', 'ad_id');
    }

    /**
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
