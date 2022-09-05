<?php

namespace Realty\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Maize\Markable\Markable;
use Maize\Markable\Models\Favorite;
use Markable\Interfaces\HasViewsInterface;
use Markable\Models\PhoneView;
use Markable\Traits\HasViewsTrait;
use Realty\Events\AdApprovedEvent;
use Realty\Events\AdDisabledEvent;
use Realty\Events\AdRejectedEvent;
use Realty\Exceptions\AdException;
use Realty\Http\Resources\AdHasPropertyResource;
use Realty\Http\Resources\PropertyResource;
use Realty\Interfaces\AdInterface;
use Realty\Interfaces\FavoriteServiceInterface;
use Realty\Interfaces\HasFavoritesInterface;
use Realty\Interfaces\HasPhoneViewsInterface;
use Realty\Interfaces\MediaServiceInterface;
use Realty\Interfaces\PhoneViewsServiceInterface;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use User\Models\User;

/**
 * Realty\Models\Ad
 *
 * @property int $id
 * @property string $status
 * @property int $category_id
 * @property string $coordinates
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \Realty\Models\AdTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\AdTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ad listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Ad onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCoordinates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Ad withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Ad withoutTrashed()
 * @mixin \Eloquent
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUserId($value)
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\Markable\Models\View[] $views
 * @property-read int|null $views_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereHasMark(\Maize\Markable\Mark $mark, \Illuminate\Database\Eloquent\Model $user, ?string $value = null)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\AdHasProperty[] $adHasProperties
 * @property-read int|null $ad_has_properties_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Realty\Models\Property[] $properties
 * @property-read int|null $properties_count
 */
class Ad extends Model implements AdInterface, HasMedia, TranslatableContract, HasViewsInterface, HasFavoritesInterface, HasPhoneViewsInterface
{
    use InteractsWithMedia;
    use Translatable;
    use SoftDeletes;
    use HasViewsTrait;
    use Searchable;
    use Markable;

    public const STATUSES = [
        'PENDING_APPROVAL' => 'pending-approval',
        'APPROVED' => 'approved',
        'DISABLED' => 'disabled',
        'REJECTED' => 'rejected',
    ];

    public array $translatedAttributes = ['caption', 'description', 'city'];

    protected static $marks = [
        Favorite::class,
        PhoneView::class,
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return [
            $this->getTranslationsArray(),
        ];
    }

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable(): bool
    {
        return $this->isApproved();
    }

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs(): string
    {
        return 'ad_index';
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param  int  $propertyId
     * @param  string|int|bool  $value
     * @return Model|AdHasProperty
     */
    public function propertyValue(int $propertyId, string|int|bool $value): Model|AdHasProperty
    {
        return $this->adHasProperties()->create(['property_id' => $propertyId, 'value' => $value]);
    }

    /**
     * @return HasMany
     */
    public function adHasProperties(): HasMany
    {
        return $this->hasMany(AdHasProperty::class, 'ad_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'ad_has_properties');
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return void
     *
     * @throws AdException
     */
    public function approve(): void
    {
        $this->assertApproved();
        $this->status = self::STATUSES['APPROVED'];
        $this->save();
        event(new AdApprovedEvent($this));
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUSES['APPROVED'];
    }

    /**
     * @return void
     *
     * @throws AdException
     */
    private function assertApproved(): void
    {
        if ($this->status === self::STATUSES['APPROVED']) {
            throw AdException::assertStatusException('Ad already approved', 0);
        }
    }

    /**
     * @return void
     *
     * @throws AdException
     */
    public function disable(): void
    {
        $this->assertDisabled();
        $this->status = self::STATUSES['DISABLED'];
        $this->save();
        event(new AdDisabledEvent($this));
    }

    /**
     * @return void
     *
     * @throws AdException
     */
    private function assertDisabled(): void
    {
        if ($this->status === self::STATUSES['DISABLED']) {
            throw AdException::assertStatusException('Ad already disabled', 1);
        }
    }

    /**
     * @return void
     *
     * @throws AdException
     */
    public function reject(string $reason): void
    {
        $this->assertRejected();
        $this->status = self::STATUSES['REJECTED'];
        $this->save();
        event(new AdRejectedEvent($this, $reason));
    }

    /**
     * @return void
     *
     * @throws AdException
     */
    private function assertRejected(): void
    {
        if ($this->status === self::STATUSES['REJECTED']) {
            throw AdException::assertStatusException('Ad already rejected', 2);
        }
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param  Media|null  $media
     * @return void
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion(MediaServiceInterface::CONVERSION_NAMES['PREVIEW'])
            ->fit(
                Manipulations::FIT_CROP,
                self::CONVERSIONS[MediaServiceInterface::CONVERSION_NAMES['PREVIEW']]['width'],
                self::CONVERSIONS[MediaServiceInterface::CONVERSION_NAMES['PREVIEW']]['height']
            )
            ->nonQueued();

        $this->addMediaConversion(MediaServiceInterface::CONVERSION_NAMES['FULL'])
            ->fit(
                Manipulations::FIT_CROP,
                self::CONVERSIONS[MediaServiceInterface::CONVERSION_NAMES['FULL']]['width'],
                self::CONVERSIONS[MediaServiceInterface::CONVERSION_NAMES['FULL']]['height']
            )
            ->nonQueued();
    }

    /**
     * @return array
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function toArray(): array
    {
        $app = app();
        $mediaService = $app->make(MediaServiceInterface::class);
        $phoneViewsService = $app->make(PhoneViewsServiceInterface::class);
        $favoriteService = $app->make(FavoriteServiceInterface::class);

        $properties = PropertyResource::collection($this->properties)->jsonSerialize();
        $adHasProperties = collect(AdHasPropertyResource::collection($this->adHasProperties)->jsonSerialize())->keyBy('propertyId');

        $result = [
            'id' => $this->id,
            'caption' => $this->caption,
            'description' => $this->description,
            'city' => $this->city,
            'translations' => $this->getTranslationsArray(),
            'status' => $this->status,
            'price' => $this->price,
            'coordinates' => $this->coordinates,
            'categoryId' => $this->category_id,
            'images' => $mediaService->prepareMedias($this->getMedia('ads')),
            'favorites' => $favoriteService->count($this),
            'phoneViews' => $phoneViewsService->count($this),
            'views' => $this->views()->count(),
            'properties' => $properties,
            'adHasProperties' => $adHasProperties,
        ];
        return $result;
    }

    /**
     * @return array
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function searchData(): array
    {
        return $this->toArray();
    }
}
