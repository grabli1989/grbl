<?php

namespace Realty\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Realty\Models\Property;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Property $property */
        $property = $this->resource;

        return [
            'id' => $property->id,
            'questionId' => $property->question_id,
            'question' => $property->question,
            'position' => $property->position,
            'slug' => $property->slug,
            'name' => $property->name,
            'value' => $property->value,
            'translations' => $property->getTranslationsArray(),
        ];
    }
}
