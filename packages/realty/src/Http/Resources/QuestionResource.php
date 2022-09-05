<?php

namespace Realty\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Realty\Models\Question;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Question $question */
        $question = $this->resource;

        return [
            'id' => $question->id,
            'propertySetId' => $question->property_set_id,
            'relateProperty' => new PropertyResource($question->relateProperty),
            'type' => $question->type,
            'slug' => $question->slug,
            'showName' => $question->show_name,
            'properties' => PropertyResource::collection($question->properties),
            'name' => $question->name,
            'translations' => $question->getTranslationsArray(),
        ];
    }
}
