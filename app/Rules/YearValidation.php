<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class YearValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value <= 1999) {
            $fail('The :attribute must be greater than 1999.');
        } elseif ($value >= now()->year) {
            $fail('The :attribute must be less than ' . now()->year);
        }
    }
}
