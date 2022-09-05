<?php

namespace Realty\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\TranslateApiInterface;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['CREATE_CATEGORY']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|array:'.implode(',', TranslateApiInterface::LANGUAGES),
            'mediaId' => 'numeric|exists:media,id',
            'position' => 'numeric',
        ];

        foreach (TranslateApiInterface::LANGUAGES as $language) {
            $rules['name.'.$language] = 'required';
        }

        return $rules;
    }
}
