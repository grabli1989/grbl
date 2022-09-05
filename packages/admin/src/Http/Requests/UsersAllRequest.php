<?php

namespace Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\PermissionsInterface;

class UsersAllRequest extends FormRequest
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
        return [];
    }

    /**
     * @return bool
     */
    public function userCan(): bool
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['USERS_ALL']);
    }
}
