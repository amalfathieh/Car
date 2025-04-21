<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
            'full_name'=> 'required|string|max:255',
            'image' => 'required',
            'ad_url' => 'required|url',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'location' => 'required|string',
        ];
    }
}
