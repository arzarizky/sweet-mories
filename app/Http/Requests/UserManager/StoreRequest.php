<?php

namespace App\Http\Requests\UserManager;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name'      =>  'required|string|max:255',
            'avatar'    =>  'nullable|image|mimes:png,jpg',
            'no_tlp'    =>  'required|numeric|min:11',
            'email'     =>  'required|email|email:rfc,dns|unique:users,email',
            'password'  =>  'required|min:8',
        ];
    }
}
