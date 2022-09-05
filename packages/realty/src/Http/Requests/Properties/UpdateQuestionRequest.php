<?php

namespace Realty\Http\Requests\Properties;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Commands\Question\UpdateQuestion;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\TranslateApiInterface;
use Realty\Models\Question;

class UpdateQuestionRequest extends FormRequest
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
            'id' => 'required|exists:questions',
            'propertySet' => 'required|exists:property_sets,id',
            'relateProperty' => 'sometimes|exists:properties,id',
            'slug' => 'required',
            'type' => 'required|in:'.implode(',', Question::TYPES),
            'showName' => 'boolean',
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
        return $this->user()->can(PermissionsInterface::PERMISSIONS['UPDATE_QUESTION']);
    }

    public function getCommand(): UpdateQuestion
    {
        return new UpdateQuestion(
            $this->get('id'),
            $this->get('propertySet'),
            $this->get('relateProperty'),
            $this->get('type'),
            $this->get('slug'),
            $this->get('showName'),
            $this->get('name'),
        );
    }
}
