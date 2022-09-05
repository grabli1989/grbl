<?php

namespace Realty\Services\Ads;

use Realty\Commands\Ads\UpdateAd;
use Realty\Interfaces\TranslateApiInterface;
use Realty\Models\Ad;
use Realty\Models\AdTranslation;

class UpdateAdService
{
    /**
     * @param  UpdateAd  $command
     * @return void
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function handle(UpdateAd $command): void
    {
        /** @var Ad $ad */
        [$images, $coordinates, $categoryId, $price, $user, $ad] = $this->getAdData($command);

        $this->fillTranslatableData($command);

        $ad->user_id = $user->id;
        $ad->coordinates = $coordinates;
        $ad->category_id = $categoryId;
        $ad->price = $price;

        $ad->save();

        $ad->media()->delete();

        foreach ($images as $position => $image) {
            $ad->addMedia($image)->withCustomProperties(['position' => $position])->toMediaCollection('ads');
        }

        $this->assignProperties($ad, $command->getProperties());
    }

    /**
     * @param  UpdateAd  $command
     * @return array
     */
    private function getAdData(UpdateAd $command): array
    {
        return [
            $command->getImages(),
            $command->getCoordinates(),
            $command->getCategoryId(),
            $command->getPrice(),
            $command->getUser(),
            $command->getAd(),
        ];
    }

    /**
     * @param  UpdateAd  $command
     * @return void
     */
    private function fillTranslatableData(UpdateAd $command): void
    {
        [$caption, $description, $city, $ad] = [
            $command->getCaption(),
            $command->getDescription(),
            $command->getCity(),
            $command->getAd(),
        ];

        foreach (TranslateApiInterface::LANGUAGES as $language) {
            /** @var AdTranslation $translate */
            $translate = $ad->translateOrNew($language);

            $translate->caption = $caption[$language];
            $translate->description = $description[$language];
            $translate->city = $city[$language];
        }
    }

    /**
     * @param  Ad  $ad
     * @param  array  $properties
     * @return void
     */
    private function assignProperties(Ad $ad, array $properties): void
    {
        $propertyIds = array_keys($properties);
        $ad->properties()->sync($propertyIds);
        foreach ($properties as $key => $value) {
            $ad->properties()->where('property_id', $key)->update(['value' => $value]);
        }
    }
}
