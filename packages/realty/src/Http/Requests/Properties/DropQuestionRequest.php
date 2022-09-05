<?php

namespace Realty\Http\Requests\Properties;

use Illuminate\Foundation\Http\FormRequest;
use Realty\Commands\Question\DropQuestion;
use Realty\Interfaces\PermissionsInterface;

class DropQuestionRequest extends FormRequest
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
            'id' => 'required|exists:questions',
        ];
    }

    /**
     * @return bool
     */
    private function userCan(): bool
    {
        return $this->user()->can(PermissionsInterface::PERMISSIONS['DROP_QUESTION']);
    }

    /**
     * @return DropQuestion
     */
    public function getCommand(): DropQuestion
    {
        return new DropQuestion($this->get('id'));
    }
}
