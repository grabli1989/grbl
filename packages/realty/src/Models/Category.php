<?php

namespace Realty\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Realty\Interfaces\CategoriesNamesInterface;
use Realty\Interfaces\MediaServiceInterface;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Realty\Models\Category
 *
 * @property int $id
 * @property int $position
 * @property string $name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \Realty\Models\CategoryTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\CategoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTranslation()
 * @mixin \Eloquent
 */
class Category extends Model implements HasMedia, TranslatableContract
{
    use InteractsWithMedia;
    use Translatable;

    public $timestamps = false;

    public array $translatedAttributes = ['name'];

    public $translationForeignKey = 'category_id';

    public $registerMediaConversionsUsingModelInstance = true;

    /**
     * @param  Media|null  $media
     * @return void
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion(MediaServiceInterface::CONVERSION_NAMES['SHORT'])
            ->fit(
                Manipulations::FIT_CROP,
                CategoriesNamesInterface::TYPES[MediaServiceInterface::CONVERSION_NAMES['SHORT']]['width'],
                CategoriesNamesInterface::TYPES[MediaServiceInterface::CONVERSION_NAMES['SHORT']]['height']
            )
            ->nonQueued();

        $this->addMediaConversion(MediaServiceInterface::CONVERSION_NAMES['LONG'])
            ->fit(
                Manipulations::FIT_CROP,
                CategoriesNamesInterface::TYPES[MediaServiceInterface::CONVERSION_NAMES['LONG']]['width'],
                CategoriesNamesInterface::TYPES[MediaServiceInterface::CONVERSION_NAMES['LONG']]['height']
            )
            ->nonQueued();
    }
}
