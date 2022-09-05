<?php

namespace Realty\Http\Requests\Properties;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Commands\Question\PickUpQuestions;

class PickUpQuestionsRequest extends FormRequest
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
        return [
            'properties' => 'required|array',
            'properties.*' => 'required|exists:properties,id',
        ];
    }

    public function getCommand(): PickUpQuestions
    {
        return new PickUpQuestions($this->get('properties'));
    }
}
