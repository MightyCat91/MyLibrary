<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 21.05.2018
 * Time: 11:50
 */

namespace App\Http\Requests;


use App\Rules\CorrectFilename;
use App\Rules\reviewIsExist;
use Illuminate\Foundation\Http\FormRequest;

class AddReview extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'review-text-field' => ['required', 'string', 'max:8192', new reviewIsExist()]
        ];
        return $rules;
    }

    public function messages()
    {
        $message = [
            'review-text-field.required' => 'Поле обязательно к заполнению',
            'review-text-field.string' => 'Вводимое значение должно быть строкой',
            'review-text-field.max' => 'Поле не должно содержать больше :max символов',
            'nameInput.unique' => 'Автор с таким именем уже существует',
        ];
        return $message;
    }
}