<?php

namespace Realty\Http\Requests\Properties;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Commands\Question\CreateSet;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\TranslateApiInterface;

class CreateSetRequest extends FormRequest
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
            'name' => 'required|array:'.implode(',', TranslateApiInterface::LANGUAGES),
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
        return $this->user()->can(PermissionsInterface::PERMISSIONS['CREATE_SET']);
    }

    /**
     * @return CreateSet
     */
    public function getCommand(): CreateSet
    {
        return new CreateSet($this->get('name'));
    }
}
