<?php

namespace Realty\Services\Categories;

use Realty\Commands\Categories\UpdateCategory;
use Realty\Interfaces\TranslateApiInterface;
use Realty\Models\Category;
use Realty\Models\CategoryTranslation;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UpdateCategoryService
{
    /**
     * @param  UpdateCategory  $command
     * @return void
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function handle(UpdateCategory $command): void
    {
        $name = $command->getName();
        $position = $command->getPosition();
        $mediaId = $command->getMediaId();

        $category = Category::find($command->getId());

        $category->position = $position;

        $this->fillTranslates($category, $name);

        $category->save();

        /** @var Media $media */
        $media = Media::find($mediaId);
        $path = $media->getPath();

        $category->media()->delete();

        $category->addMedia($path)
            ->preservingOriginal()
            ->toMediaCollection('categories');
    }

    /**
     * @param  Category  $category
     * @param  array  $name
     * @return void
     */
    private function fillTranslates(Category $category, array $name): void
    {
        foreach (TranslateApiInterface::LANGUAGES as $language) {
            /** @var CategoryTranslation $translate */
            $translate = $category->translateOrNew($language);
            $translate->name = $name[$language];
        }
    }
}
