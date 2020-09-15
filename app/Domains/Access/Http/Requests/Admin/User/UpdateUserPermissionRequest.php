<?php

namespace App\Domains\Access\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin() && !$this->user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ];
    }
}
