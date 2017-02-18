<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: дописать проверку авторизованности юзера добавляющего автора
        //TODO: реализовать страницу 403
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->ajax()) {
            $rules = [
                'imageInput' => 'required|image|mimes:jpg,jpeg,png,gif|max:1240'
            ];
        } else {
            $rules = [
                'nameInput' => 'required|string|max:128|unique:authors,name',
                'biographyInput' => 'required|string|max:2048',
                'imageInput' => 'required|image|mimes:jpg,jpeg,png,gif|max:1240'
            ];
        }
        return $rules;
    }
}
