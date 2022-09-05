<?php

namespace Realty\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\TranslateApiInterface;
use Realty\Models\Property;

class CreateAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
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
}
