<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 27.06.2017
 * Time: 20:30
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class EditUserProfile extends FormRequest
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
        if ($this->ajax()) {
            $rules = [
                'password' => 'required|string|max:255',
                'email' => 'email|max:255|unique:users,email|required_with:password',
                'newPassword' => 'string|max:255|required_with:password|different:password',
            ];
        } else {
            $rules = [
            ];
        }
        return $rules;
    }

    public function messages(){
        return [
            'password.required' => 'Поле обязательно к заполнению',
            'password.string' => 'Вводимое значение должно быть строкой',
            'password.max' => 'Пароль не должен содержать больше :max символов',
            'email.unique' => 'Такой email уже существует',
            'email.email' => 'Неправильный формат email',
            'email.required_with' => 'Должен быть введен текущий пароль',
            'email.max' => 'Email не должен содержать больше :max символов',
            'newPassword.string' => 'Новый пароль должен быть строкой',
            'newPassword.max' => 'Пароль не должен содержать больше :max символов',
            'newPassword.required_with' => 'Должен быть введен старый пароль',
            'newPassword.different' => 'Текущий пароль не должен совпадать со старым',
        ];
    }
}