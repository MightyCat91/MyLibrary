<?php

namespace App\Http\Requests;

use App\Rules\CorrectFilename;
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
                'imageInput.*' => ['image','mimes:jpg,jpeg,png,gif','max:6080','dimensions:min_width=100,min_height=200', new CorrectFilename()],
                'imageInput' => 'max_files_count:3',
            ];
        } else {
            $rules = [
                'nameInput' => 'required|string|max:64|unique:books,name',
                'isbnInput' => 'string|max:20',
                'yearInput' => 'nullable|date_format:Y|before:yesterday',
                'pageCountsInput' => 'required|integer|min:0|digits_between:1,5',
                'descriptionInput' => 'required|string|max:2048',
                'imageInput.*' => ['required','image','mimes:jpg,jpeg,png,gif','max:6080','dimensions:min_width=100,min_height=200', new CorrectFilename()],
                'imageInput' => 'max_files_count:3',
                'categoryInput.*' => 'exists:categories,name',
                'authorInput.*' => 'required|exists:authors,name',
                'publisherInput.*' => 'exists:publishers,name',
            ];
        }
        return $rules;
    }

    public function messages(){
        return [
            'nameInput.required' => 'Поле обязательно к заполнению',
            'nameInput.string' => 'Вводимое значение должно быть строкой',
            'nameInput.max' => 'Название книги не должно содержать больше :max символов',
            'nameInput.unique' => 'Книга с таким именем уже существует',
            'descriptionInput.required' => 'Поле обязательно к заполнению',
            'descriptionInput.string' => 'Вводимое значение должно быть строкой',
            'descriptionInput.max' => 'Описание не должно содержать больше :max символов',
            'isbnInput.string' => 'Вводимое значение должно быть строкой',
            'isbnInput.max' => 'Поле ISBN не должно содержать больше :max символов',
            'yearInput.date_format' => 'Дата не соответствует формату',
            'yearInput.before' => 'Дата не должна быть позднее текущего дня',
            'pageCountsInput.required' => 'Поле обязательно к заполнению',
            'pageCountsInput.integer' => 'Поле должно быть положительным целым числом',
            'pageCountsInput.min' => 'Поле не может быть меньше :value',
            'pageCountsInput.digits_between' => 'Поле должно содержать от :min до :max цифр',
            'categoryInput.*.exists' => 'Введенный жанр отсутсвует в базе',
            'authorInput.*.exists' => 'Введенный жанр отсутсвует в базе',
            'authorInput.*.required' => 'Поле обязательно к заполнению',
            'publisherInput.*.exists' => 'Введенный жанр отсутсвует в базе',
            'imageInput.*.required' => 'Необходимо загрузить файл',
            'imageInput.*.image' => 'Файл ":fileName" должен быть изображением',
            'imageInput.*.mimes' => 'Файл ":fileName" должен иметь расширения: :values',
            'imageInput.*.max' => 'Максимальный размер файла ":fileName" не должен превышать 6 Мб',
            'imageInput.*.dimensions' => 'Файл ":fileName" имеет слишком маленькое разрешение',
            'imageInput.max_files_count' => 'Максимальное количество изображений не должно превышать :maxFilesCount',
        ];
    }
}
