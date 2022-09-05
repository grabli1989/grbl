<?php

namespace Realty\Http\Requests\Properties;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Commands\Question\UpdateProperty;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\TranslateApiInterface;

class UpdatePropertyRequest extends FormRequest
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
            'id' => 'required|exists:properties',
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
        return $this->user()->can(PermissionsInterface::PERMISSIONS['UPDATE_PROPERTY']);
    }

    /**
     * @return UpdateProperty
     */
    public function getCommand(): UpdateProperty
    {
        return new UpdateProperty(
            $this->get('id'),
            $this->get('questionId'),
            $this->get('position'),
            $this->get('slug'),
            $this->get('name'),
            $this->get('value', $this->get('name', [])),
        );
    }
}
