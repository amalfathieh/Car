<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name'=>'required|string|min:3|max:255',
            'email'=>'required|email|lowercase|unique:users,email',
            'phone' => 'required|min:7',
            'password'=>'required|min:8',
            'profile_picture' => 'image|max:1048576',
            'city'=>'required|string',
            'country'=>'required|string',
            'role'=>'required|in:user,admin',
        ];
    }
}
