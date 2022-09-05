<?php

namespace Translate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\TranslateApiInterface;

class TranslateRequest extends FormRequest
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
            'source' => 'required|in:'.implode(',', TranslateApiInterface::LANGUAGES),
            'target' => 'required|in:'.implode(',', TranslateApiInterface::LANGUAGES),
            'text' => 'required',
        ];
    }
}
