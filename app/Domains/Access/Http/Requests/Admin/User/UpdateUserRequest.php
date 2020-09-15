<?php

namespace App\Domains\Access\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin() && !$this->user->isMasterAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role' => 'required|string|exists:roles,name',
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user)
            ],
        ];
    }
}
