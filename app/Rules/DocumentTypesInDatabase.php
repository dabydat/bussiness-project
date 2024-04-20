<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class DocumentTypesInDatabase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Se validan los tipos de documentos para  las empresas y se indica cuales estan disponibles
        $document_types = DB::table('document_types')->pluck('description')->toArray();
        if (!in_array($value, $document_types)) {
            $document_types = implode(', ', $document_types);
            $fail('El campo :attribute no es válido. Los valores válidos son: ' . $document_types);
        }
    }
}
