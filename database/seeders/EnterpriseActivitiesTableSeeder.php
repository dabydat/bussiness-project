<?php

namespace Database\Seeders;

use App\Models\Enterprise\Activity;
use App\Models\Enterprise\Enterprise;
use App\Models\Enterprise\EnterpriseActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EnterpriseActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enterprises = Enterprise::pluck('id')->toArray();
        $activities = Activity::pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            EnterpriseActivity::create([
                'enterprise_id' => $faker->randomElement($enterprises),
                'activity_id' => $faker->randomElement($activities)
            ]);
        }
    }
}
