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
                'imageInput' => 'image|mimes:jpg,jpeg,png,gif|max:6080'
            ];
        } else {
            $rules = [
                'nameInput' => 'required|string|max:128|unique:authors,name',
                'biographyInput' => 'required|string|max:2048',
                'imageInput' => 'required|image|mimes:jpg,jpeg,png,gif|max:6080|dimensions:min_width=100,
                min_height=200',
                'seriesInput.*' => 'string|max:128|unique:author_series,name',
                'categoryInput.*' => 'exists:categories,name',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        $message = [
            'nameInput.required' => 'Поле обязательно к заполнению',
            'nameInput.string' => 'Вводимое значение должно быть строкой',
            'nameInput.max' => 'Имя не должно содержать больше :max символов',
            'nameInput.unique' => 'Автор с таким именем уже существует',
            'biographyInput.required' => 'Поле обязательно к заполнению',
            'biographyInput.string' => 'Вводимое значение должно быть строкой',
            'biographyInput.max' => 'Биография не должна содержать больше :max символов',
            'imageInput.required' => 'Необходимо загрузить файл',
            'imageInput.image' => 'Загружаемый файл должен быть изображением',
            'imageInput.mimes' => 'Загружаемый файл должен иметь расширения: :values',
            'imageInput.max' => 'Максимальный размер загружаемого файла не должен превышать :max',
            'imageInput.dimension' => 'Загруженное изображение имеет некорректное разрешение',
            'seriesInput.string' => 'Вводимое значение должно быть строкой',
            'seriesInput.max' => 'Имя не должно содержать больше :max символов',
            'seriesInput.unique' => 'Серия книг этого автора с таким именем уже существует',
            'categoryInput.*.exists' => 'Введенный жанр отсутсвует в базе',
        ];
        return $message;
    }
}
