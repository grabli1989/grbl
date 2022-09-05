<?php

namespace Realty\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Interfaces\PermissionsInterface;
use Realty\Models\Ad;

class RemoveAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isOwner() || $this->userCan();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:ads',
        ];
    }

    /**
     * @return bool
     */
    private function userCan(): bool
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['DELETE_AD']);
    }

    /**
     * @return bool
     */
    private function isOwner(): bool
    {
        if ($ad = Ad::find($this->id)) {
            return $ad->user_id === $this->user()->id;
        }

        return false;
    }
}
