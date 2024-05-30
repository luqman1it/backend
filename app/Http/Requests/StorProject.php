<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorProject extends FormRequest
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
       'name'=>'required|string|max:255|unique:projects',
       'description'=>'required|string|max:255',
       'img_url'=> 'required|file|image|mimes:png,jpg|max:10000|mimetypes:image/jpeg,image/png,image/jpg',
       'link'=>'required|string|max:255|unique:projects',
       'type_id'=>'required|integer',
        ];
    }
}
