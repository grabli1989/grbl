<?php

namespace Realty\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Realty\Models\Question
 *
 * @property int $id
 * @property int $property_set_id
 * @property int $relate_property_id
 * @property string $type
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Realty\Models\QuestionTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\QuestionTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Question listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Question orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Question orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Question orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Question translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePropertySetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereRelateQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question withTranslation()
 * @mixin \Eloquent
 * @property int $show_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\Property[] $properties
 * @property-read int|null $properties_count
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereShowName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereRelatePropertyId($value)
 * @property-read \Realty\Models\PropertySet $propertySet
 * @property-read \Realty\Models\Property|null $relateProperty
 */
class Question extends Model implements TranslatableContract
{
    use Translatable;

    public const TYPES = [
        'SELECT' => 'select',
        'MULTIPLE_SELECT' => 'multiple_select',
        'RADIO' => 'radio',
        'CHECKBOX' => 'checkbox',
        'TEXT' => 'text',
        'TEXTAREA' => 'textarea',
        'NUMBER' => 'number',
    ];

    protected $fillable = [
        'property_set_id',
        'relate_property_id',
        'type',
        'slug',
        'show_name',
    ];

    public array $translatedAttributes = ['name'];

    /**
     * @return HasMany
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    /**
     * @return BelongsTo
     */
    public function propertySet(): BelongsTo
    {
        return $this->belongsTo(PropertySet::class);
    }

    /**
     * @return HasOne
     */
    public function relateProperty(): HasOne
    {
        return $this->hasOne(Property::class, 'id', 'relate_property_id');
    }
}
