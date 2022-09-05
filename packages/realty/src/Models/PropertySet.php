<?php

namespace Realty\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Realty\Models\PropertySet
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Realty\Models\PropertySetTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\PropertySetTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet translated()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertySet withTranslation()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\Question[] $questions
 * @property-read int|null $questions_count
 */
class PropertySet extends Model implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name'];

    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'property_set_id', 'id');
    }
}
