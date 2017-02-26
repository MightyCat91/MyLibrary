<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookAddRequest extends FormRequest
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
                'imageInput' => 'image|mimes:jpg,jpeg,png,gif|max:6080'
            ];
        } else {
            $rules = [
                'nameInput' => 'required|string|max:128|unique:books,name',
                'isbnInput' => 'nullable|string|max:20',
                'yearInput' => 'nullable|date_format:Y|before:yesterday',
                'pageCountsInput' => 'required|integer|min:0|digits_between:1,4',
                'descriptionInput' => 'required|string|max:2048',
                'imageInput' => 'required|image|mimes:jpg,jpeg,png,gif|max:6080|dimensions:min_width=100,min_height=200'

            ];
            foreach(array_keys($this->input()) as $name) {
                switch($name) {
                    case (preg_match('/categoryInput-[0-9]+/', $name)):
                        $rules[$name] = 'nullable|exists:categories,name';
                        break;
                    case (preg_match('/authorInput-[0-9]+/', $name)):
                        $rules[$name] = 'nullable|exists:authors,name';
                        break;
                    case (preg_match('/publisherInput-[0-9]+/', $name)):
                        $rules[$name] = 'nullable|exists:publishers,name';
                        break;
                }
            }
        }
        return $rules;
    }

    public function messages(){
        return [
            'nameInput.required' => 'Поле обязательно к заполнению',
            'nameInput.string' => 'Вводимое значение должно быть строкой',
            'nameInput.max' => 'Имя не должно содержать больше :max символов',
            'nameInput.unique' => 'Книга с таким именем уже существует',
            'descriptionInput.required' => 'Поле обязательно к заполнению',
            'descriptionInput.string' => 'Вводимое значение должно быть строкой',
            'descriptionInput.max' => 'Описание не должно содержать больше :max символов',
            'isbnInput.string' => 'Вводимое значение должно быть строкой',
            'isbnInput.max' => 'Поле ISBN не должно содержать больше :max символов',
            'yearInput.date_format' => 'Дата не соответствует значению :format',
            'yearInput.before' => 'Дата не должна быть позднее :date года',
            'pageCountsInput.required' => 'Поле обязательно к заполнению',
            'pageCountsInput.integer' => 'Поле должно быть положительным целым числом',
            'pageCountsInput.min' => 'Поле не может быть меньше :value',
            'pageCountsInput.digits_between' => 'Поле должно содержать от :min до :max цифр',
            'categoryInput-1.exists' => 'Выбранный жанр некорректен',
            'authorInput-1.exists' => 'Выбранный автор некорректен',
            'publisherInput-1.exists' => 'Выбранный издатель некорректен',
            'imageInput.required' => 'Необходимо загрузить файл',
            'imageInput.image' => 'Загружаемый файл должен быть изображением',
            'imageInput.mimes' => 'Загружаемый файл должен иметь расширения: :values',
            'imageInput.max' => 'Максимальный размер загружаемого файла не должен превышать :max',
        ];
    }
}
