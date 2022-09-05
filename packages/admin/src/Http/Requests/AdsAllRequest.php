<?php

namespace Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\PermissionsInterface;
use Realty\Models\Ad;

class AdsAllRequest extends FormRequest
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
            'status' => 'sometimes|in:' . implode(',', array_merge(Ad::STATUSES, ['DELETED' => 'deleted']))
        ];
    }

    /**
     * @return bool
     */
    public function userCan(): bool
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['ADS_ALL']);
    }
}
