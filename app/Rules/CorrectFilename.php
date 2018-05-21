<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CorrectFilename implements Rule
{
    protected $fileName;

    /**
     * Create a new rule instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->getClientOriginalName());
        return !str_contains($this->fileName, ["'", '"']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Файл "' . $this->fileName . '" содержит некорректные символы в имени';
    }
}
