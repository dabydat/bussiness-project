<?php

namespace Database\Seeders;

use App\Enums\Enterprise\DocumentTypeEnum;
use App\Models\Enterprise\DocumentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            DocumentTypeEnum::DNI,
            DocumentTypeEnum::CIF,
            DocumentTypeEnum::NIE,
            DocumentTypeEnum::NIF,
            DocumentTypeEnum::PASSPORT,
            DocumentTypeEnum::OTHER
        ];

        foreach ($documentTypes as $documentType) {
            DocumentType::create(['description' => $documentType]);
        }
    }
}
