<?php

namespace App\Domains\Access\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user())
            ],
            'password' => 'sometimes|required|string|min:8|confirmed',
        ];
    }
}
