<?php

namespace Realty\Http\Requests\Properties;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Commands\Question\UpdateSet;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\TranslateApiInterface;

class UpdateSetRequest extends FormRequest
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
            'id' => 'required|exists:property_sets',
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
        return $this->user()->can(PermissionsInterface::PERMISSIONS['UPDATE_SET']);
    }

    /**
     * @return UpdateSet
     */
    public function getCommand(): UpdateSet
    {
        return new UpdateSet($this->get('id'), $this->get('name'));
    }
}
