<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class UsersInDatabase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $users = DB::table('users')->pluck('id')->toArray();
        if (!in_array($value, $users)) {
            $fail('The user with ID: ' . $value . ' does not exist.');
        }
    }
}
