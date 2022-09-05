<?php

namespace User\Http\Requests\Permissions;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\PermissionsInterface;

class UserRevokePermissionToRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['ASSIGN_PERMISSION']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userId' => 'required|exists:users,id',
            'permissionId' => 'required|exists:permissions,id',
        ];
    }
}
