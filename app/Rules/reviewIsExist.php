<?php

namespace App\Rules;

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
        \Debugbar::info($value);
        \Debugbar::info(!Rule::exists('reviews')->where(function ($query) {
            $query->where('book_id', 1)->where(function ($query) {
                $query->where('user_id', auth()->id());
            });
        }));
        return !Rule::exists('reviews')->where(function ($query) {
            $query->where('book_id', 1);
            $query->where('user_id', auth()->id());
        });
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
