<?php

namespace Realty\Services\Categories;

use Realty\Commands\Categories\CreateCategory;
use Realty\Interfaces\TranslateApiInterface;
use Realty\Models\Category;
use Realty\Models\CategoryTranslation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CreateCategoryService
{
    /**
     * @param  CreateCategory  $command
     * @return void
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function handle(CreateCategory $command): void
    {
        $name = $command->getName();
        $position = $command->getPosition();
        $mediaId = $command->getMediaId();

        $category = new Category();
        $category->position = $position;

        $this->fillTranslates($category, $name);

        $category->save();

        /** @var Media $media */
        $media = Media::find($mediaId);
        $path = $media->getPath();
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
