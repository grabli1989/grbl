<?php

namespace Realty\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Exceptions\AdException;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\TranslateApiInterface;
use Realty\Models\Ad;
use Realty\Models\Property;

class UpdateAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isOwner() || $this->userCan();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'id' => 'required|exists:ads',
            'caption' => 'required|array:'.implode(',', TranslateApiInterface::LANGUAGES),
            'description' => 'required|array:'.implode(',', TranslateApiInterface::LANGUAGES),
            'city' => 'required|array:'.implode(',', TranslateApiInterface::LANGUAGES),
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
            'coordinates' => 'required',
            'categoryId' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'properties' => 'array:'.implode(',', Property::all()->pluck('id')->toArray()),
        ];

        foreach (TranslateApiInterface::LANGUAGES as $language) {
            $rules['caption.'.$language] = 'required';
            $rules['description.'.$language] = 'required';
            $rules['city.'.$language] = 'required';
        }

        return $rules;
    }

    /**
     * @return bool
     */
    private function userCan(): bool
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['UPDATE_AD']);
    }

    /**
     * @return bool
     *
     * @throws AdException
     */
    private function isOwner(): bool
    {
        if (! $ad = Ad::find($this->id)) {
            throw new AdException('Ob not found');
        }

        return $ad->user_id === $this->user()->id;
    }
}
