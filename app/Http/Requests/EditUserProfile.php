<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 27.06.2017
 * Time: 20:30
 */

namespace App\Http\Requests;


use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        \Debugbar::info($this->request);
        \Debugbar::info($this->route()->getName());
        if ($this->ajax()) {
            $rules = [
                'oldPassword' => [
                    'required_without:imageInput',
                    'string',
                    'max:255',
                    'check_password'
                ],
                'email' => [
                    'required_without:imageInput',
                    'email',
                    'max:255',
                    'required_with:password',
                    Rule::unique('users')->ignore(\Auth::id()),
                ],
                'password' => 'string|max:255|nullable|required_if:password,*|different:password',
                'imageInput' => 'image|mimes:jpg,jpeg,png,gif|max:6080',
            ];
        } else {
            $rules = [
                'login' => [
                    'nullable',
                    'string',
                    'max:128',
                    Rule::unique('users')->ignore(\Auth::id()),
                ],
                'name' => 'required|string|max:255'
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            '*.required_without' => 'Поле обязательно к заполнению',
            '*.string' => 'Вводимое значение должно быть строкой',
            'oldPassword.max' => 'Пароль не должен содержать больше :max символов',
            'oldPassword.check_password' => 'Пароль не совпадает с ранее сохраненным',
            'email.unique' => 'Такой email уже существует',
            'email.email' => 'Неправильный формат email',
            'email.required_with' => 'Должен быть введен текущий пароль',
            'email.max' => 'Email не должен содержать больше :max символов',
            'password.max' => 'Пароль не должен содержать больше :max символов',
            'password.required_with' => 'Должен быть введен старый пароль',
            'password.different' => 'Текущий пароль не должен совпадать со старым',
            'login.max' => 'Логин не должен содержать больше :max символов',
            'login.unique' => 'Такой логин уже существует',
            'name.max' => 'Имя не должен содержать больше :max символов',
            'imageInput.required' => 'Необходимо загрузить файл',
            'imageInput.image' => 'Загружаемый файл должен быть изображением',
            'imageInput.mimes' => 'Загружаемый файл должен иметь расширения: :values',
            'imageInput.max' => 'Максимальный размер загружаемого файла не должен превышать :max',
            'imageInput.dimension' => 'Загруженное изображение имеет некорректное разрешение',
        ];
    }
}