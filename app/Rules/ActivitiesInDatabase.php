<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class ActivitiesInDatabase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Obtener todas las actividades y se validan por tipo de dato para saber su funcionamiento y validacion a aplicar
        $activities = DB::table('activities')->pluck('id')->toArray();
        if (gettype($value) === 'array') {
            foreach ($value as $key) {
                if (!in_array($key, $activities)) {
                    $fail('The activity with ID: ' . $key . ' does not exist');
                }
            }
        } elseif (gettype($value) === 'integer') {
            if (!in_array($value, $activities)) {
                $fail('The activity with ID: ' . $value . ' does not exist');
            }
        } else {
            $fail('The field must be an integer or an array of valids IDs of activities.');
        }
    }
}
