<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class EnterprisesInDatabase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $enterprises = DB::table('enterprises')->pluck('id')->toArray();
        if (!in_array($value, $enterprises)) {
            $fail('The enterprise with ID: ' . $value . ' does not exist');
        }
    }
}
