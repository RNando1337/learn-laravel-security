<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserRegister extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:12']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Field :Attribute is required',
            'regex' => 'No numbers allowed in :Attribute',
            'email' => ':Attribute wrong format',
            'email.unique' => ':Attribute is already exist',
            'password.min' => ':Attribute minimal 12 characters'
        ];
    }
}
