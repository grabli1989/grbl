<?php

namespace Settings\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\PermissionsInterface;

class DropSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['DROP_SETTING']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'property' => 'required',
        ];
    }
}
