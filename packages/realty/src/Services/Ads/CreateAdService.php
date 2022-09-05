<?php

namespace Realty\Services\Ads;

use Realty\Commands\Ads\CreateAd;
use Realty\Interfaces\TranslateApiInterface;
use Realty\Models\Ad;
use Realty\Models\AdTranslation;

class CreateAdService
{
    /**
     * @param  CreateAd  $command
     * @return void
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function handle(CreateAd $command): void
    {
        $ad = new Ad();
        [$images, $coordinates, $categoryId, $price, $user] = $this->getAdData($command);

        $this->fillTranslatableData($ad, $command);

        $ad->user_id = $user->id;
        $ad->coordinates = $coordinates;
        $ad->category_id = $categoryId;
        $ad->price = $price;

        $ad->save();

        foreach ($images as $position => $image) {
            $ad->addMedia($image)->withCustomProperties(['position' => $position])->toMediaCollection('ads');
        }

        $this->assignProperties($ad, $command->getProperties());
    }

    /**
     * @param  CreateAd  $command
     * @return array
     */
    private function getAdData(CreateAd $command): array
    {
        return [
            $command->getImages(),
            $command->getCoordinates(),
            $command->getCategoryId(),
            $command->getPrice(),
            $command->getUser(),
        ];
    }

    /**
     * @param  CreateAd  $command
     * @return void
     */
    private function fillTranslatableData(Ad $ad, CreateAd $command): void
    {
        [$caption, $description, $city] = [
            $command->getCaption(),
            $command->getDescription(),
            $command->getCity(),
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
        foreach ($properties as $id => $value) {
            $ad->propertyValue($id, $value);
        }
    }
}
