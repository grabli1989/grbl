<?php

namespace Realty\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Models\Ad;

class SelfAdsRequest extends FormRequest
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
            'status' => 'required|in:' . implode(',', array_merge(Ad::STATUSES, ['DELETED' => 'deleted']))
        ];
    }
}
