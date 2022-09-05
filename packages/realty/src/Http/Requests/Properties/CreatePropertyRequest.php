<?php

namespace Realty\Http\Requests\Properties;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Commands\Question\CreateProperty;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\TranslateApiInterface;

class CreatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->userCan();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'questionId' => 'required|exists:questions,id',
            'position' => 'required|numeric',
            'slug' => 'required',
            'name' => 'required|array:'.implode(',', TranslateApiInterface::LANGUAGES),
            'value' => 'array:'.implode(',', TranslateApiInterface::LANGUAGES),
        ];

        foreach (TranslateApiInterface::LANGUAGES as $language) {
            $rules['name.'.$language] = 'required';
        }

        return $rules;
    }

    /**
     * @return bool
     */
    private function userCan(): bool
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['CREATE_PROPERTY']);
    }

    /**
     * @return CreateProperty
     */
    public function getCommand(): CreateProperty
    {
        return new CreateProperty(
            $this->get('questionId'),
            $this->get('position'),
            $this->get('slug'),
            $this->get('name'),
            $this->get('value', $this->get('name', [])),
        );
    }
}
