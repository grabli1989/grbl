<?php

namespace Realty\Http\Requests\Properties;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Commands\Question\DropProperty;
use Realty\Interfaces\PermissionsInterface;

class DropPropertyRequest extends FormRequest
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
            'id' => 'required|exists:properties',
        ];
    }

    /**
     * @return bool
     */
    private function userCan(): bool
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['DROP_PROPERTY']);
    }

    /**
     * @return DropProperty
     */
    public function getCommand(): DropProperty
    {
        return new DropProperty(
            $this->get('id'),
        );
    }
}
