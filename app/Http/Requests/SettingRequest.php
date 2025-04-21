<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'site_name' => 'required|string|max:255',
            'icon_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'facebook_link' => 'required|url',
            'instagram_link' => '',
            'whatsapp_number' => 'required|min:10',
            'image_1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_3' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'text_1'=> 'required|string|max:255',
            'text_2'=> 'required|string|max:255',
            'text_3'=> 'required|string|max:255',
        ];
    }
}
