<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class StatusEnterpriseInDatabase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $statuses = DB::table('status_enterprises')->pluck('description')->toArray();
        if (!in_array($value, $statuses)) {
            $statuses = implode(', ', $statuses);
            $fail('El campo :attribute no es válido. Los valores válidos son: ' . $statuses);
        }
    }
}
