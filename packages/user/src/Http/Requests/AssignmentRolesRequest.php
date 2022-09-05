<?php

namespace User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use Realty\Interfaces\PermissionsInterface;
use Realty\Interfaces\RolesInterface;
use Spatie\Permission\Models\Role;
use User\Commands\AssignmentRoles;

class AssignmentRolesRequest extends FormRequest
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
    #[ArrayShape(['roles' => 'string', 'roles.*' => 'array'])]
 public function rules(): array
 {
     return [
         'roles' => 'required|array',
         'roles.*' => [
             'exists:roles,id',
             Rule::in($this->userRolesIds()),
         ],
     ];
 }

    /**
     * @return bool
     */
    private function userCan(): bool
    {
        return ! $this->user()->canAny(PermissionsInterface::USER_PERMISSIONS);
    }

    /**
     * @return Collection
     */
    private function userRolesIds(): Collection
    {
        return Role::query()->whereIn('name', RolesInterface::USER_ROLES)->get()->pluck('id');
    }

    /**
     * @return AssignmentRoles
     */
    public function getCommand(): AssignmentRoles
    {
        return new AssignmentRoles($this->get('roles'));
    }
}
