<?php

namespace Admin\Http\Requests;

use Admin\Commands\UpdateUser;
use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\PermissionsInterface;

class UpdateUserRequest extends FormRequest
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
        return [
            'id' => 'required|exists:users',
            'email' => 'required|email',
        ];
    }

    /**
     * @return bool
     */
    public function userCan(): bool
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['UPDATE_USER']);
    }

    /**
     * @return UpdateUser
     */
    public function getCommand(): UpdateUser
    {
        return new UpdateUser(
            $this->get('id'),
            $this->get('firstName', ''),
            $this->get('lastName', ''),
            $this->get('middleName', ''),
            $this->get('email')
        );
    }
}
