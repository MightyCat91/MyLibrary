<?php

namespace App\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class reviewIsExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !DB::table('reviews')->where([
            ['user_id', '=', auth()->id()],
            ['book_id', '=', $value],
        ])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'У Вас уже есть рецензия на эту книгу';
    }
}
