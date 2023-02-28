<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|min:9|max:11|unique:users,phone',
            'job' => 'required',
            'about' => 'nullable',
            'password' => 'required|confirmed|min:8',
            'profile_img' => 'image|file|max:1500',
            'twitter' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ];
    }
}
