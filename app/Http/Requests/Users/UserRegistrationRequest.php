<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'mobile' => 'required|numeric|digits:12|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
        ];
    }

    public function messages() {
        return [
            'name.min' => 'Name too short',
        ];
    }
}
