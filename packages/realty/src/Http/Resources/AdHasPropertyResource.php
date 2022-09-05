<?php

namespace Realty\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Realty\Models\AdHasProperty;
use Realty\Models\Property;

class AdHasPropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var AdHasProperty $adHasProperty */
        $adHasProperty = $this->resource;

        return [
            'adId' => $adHasProperty->ad_id,
            'propertyId' => $adHasProperty->property_id,
            'value' => $adHasProperty->value,
            'property' => new PropertyResource($adHasProperty->property),
        ];
    }
}
