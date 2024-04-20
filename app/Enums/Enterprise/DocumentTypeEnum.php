<?php

namespace App\Enums\Enterprise;
// Enumerador de tipos de documento de las empresas
enum DocumentTypeEnum
{
    const DNI = 'dni';
    const CIF = 'cif';
    const NIE = 'nie';
    const NIF = 'nif';
    const PASSPORT = 'passport';
    const OTHER = 'other';
}