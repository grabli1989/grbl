<?php

namespace Photo\Media;

use JetBrains\PhpStorm\ArrayShape;
use Realty\Interfaces\MediaServiceInterface;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaService implements MediaServiceInterface
{
    /**
     * @param  MediaCollection|Media[]  $collection
     * @return array
     */
    public function prepareMedias(array|MediaCollection $collection): array
    {
        $result = [];
        foreach ($collection as $media) {
            $result[] = $this->prepareMedia($media);
        }

        return $result;
    }

    /**
     * @param  Media  $media
     * @return array
     */
    #[ArrayShape(['id' => 'int', 'preview' => 'array', 'full' => 'array', 'originalSize' => 'int'])]
    public function prepareMedia(Media $media): array
    {
        $data = ['id' => $media->id];

        foreach (MediaServiceInterface::CONVERSION_NAMES as $conversionName) {
            if ($media->hasGeneratedConversion($conversionName)) {
                $data[$conversionName] = ['url' => $media->getUrl($conversionName)];
            }
        }

        $data['originalSize'] = $media->size;
        $data['original'] = $media->originalUrl;
        $data['customProperties'] = $media->custom_properties;

        return $data;
    }
}
