<?php

namespace User\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\PermissionsInterface;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['UPDATE_ROLE']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:roles',
            'name' => 'required',
        ];
    }
}
