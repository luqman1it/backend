<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProject extends FormRequest
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
            'name'=>'nullable|string|max:255',
            'description'=>'nullable|string|max:255',
            'img_url'=>'nullable|file|image|mimetypes:png,jpg,jpeg|mimetypes:image/jpeg,image/jpg',
            'link'=>'nullable|string|max:255',
            'type_id'=>'nullable|integer',
        ];
    }
}
