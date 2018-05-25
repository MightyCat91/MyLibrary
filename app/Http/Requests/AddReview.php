<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 21.05.2018
 * Time: 11:50
 */

namespace App\Http\Requests;


use App\Rules\reviewIsExist;

class AddReview
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
    public static function rules()
    {
        $rules = [
            'review' => ['required', 'string', 'max:8192'],
            'id' => ['required', 'exists:books,id', new reviewIsExist()]
        ];
        return $rules;
    }

    public static function messages()
    {
        $message = [
            'review.required' => 'Поле текста рецензии не должно быть пустым',
            'review.string' => 'Вводимое значение должно быть строкой',
            'review.max' => 'Поле не должно содержать больше :max символов',
            'id.required' => 'Ошибка при добавлении рецензии. Идентификатор книги не найден либо некорректен',
            'id.exists' => 'Ошибка при добавлении рецензии. Идентификатор книги не найден либо некорректен'
        ];
        return $message;
    }
}