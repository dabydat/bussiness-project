<?php

namespace Database\Seeders;

use App\Enums\Enterprise\StatusEnum;
use App\Models\Enterprise\StatusEnterprise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusEnterpriseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusEnterprise = [
            StatusEnum::ACTIVE,
            StatusEnum::INACTIVE
        ];
        

        foreach ($statusEnterprise as $status) {
            StatusEnterprise::create(['description' => $status]);
        }

    }
}
