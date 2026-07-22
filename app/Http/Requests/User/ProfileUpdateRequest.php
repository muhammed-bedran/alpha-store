<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' =>[
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
                ],
            'current_password' => ['nullable','required_with:password', 'current_password:web'],
            'password' => ['nullable', 'confirmed'],

        ];
    }
    public function messages()
    {
        return [
            'current_password.current_password' => __('dashboard.current_password_invalid'),
            'current_password.required_with' => __('dashboard.current_password_required'),
        ];
    }
}
