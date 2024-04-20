<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class CountriesInDatabase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $countries = DB::table('countries')->pluck('id')->toArray();
        if (!in_array($value, $countries)) {
            $fail('The country with ID: ' . $value . ' does not exist.');
        }
    }
}
