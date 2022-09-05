<?php

namespace Realty\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Realty\Models\PropertySet;

class PropertySetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var PropertySet $propertySet */
        $propertySet = $this->resource;

        return [
            'id' => $propertySet->id,
            'name' => $propertySet->name,
            'questions' => QuestionResource::collection($propertySet->questions),
            'translations' => $propertySet->getTranslationsArray(),
        ];
    }
}
