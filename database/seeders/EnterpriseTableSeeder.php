<?php

namespace Database\Seeders;

use App\Enums\Enterprise\DocumentTypeEnum;
use App\Enums\Enterprise\StatusEnum;
use App\Models\Enterprise\Enterprise;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnterpriseTableSeeder extends Seeder
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

        $statusEnterprise = [
            StatusEnum::ACTIVE,
            StatusEnum::INACTIVE
        ];
        
        $faker = Faker::create();
        for ($i = 0; $i < 11; $i++) {
            Enterprise::create(
                [
                    "name" => $faker->name,
                    "email" => $faker->unique()->safeEmail,
                    "document_type" => $faker->randomElement($documentTypes),
                    "status" => $faker->randomElement($statusEnterprise),
                    "user_id" => $faker->numberBetween(1, 10),
                    "country_id" => $faker->numberBetween(1, 60),
                    "location" => $faker->city,
                    "phone_number" => $faker->phoneNumber,
                    "created_at" => $faker->dateTimeThisDecade->format('Y-m-d H:i:s'),
                    "updated_at" => $faker->dateTimeThisDecade->format('Y-m-d H:i:s'),
                ]
            );
        }
    }
}
