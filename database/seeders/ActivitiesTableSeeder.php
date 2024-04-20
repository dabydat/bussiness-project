<?php

namespace Database\Seeders;

use App\Models\Enterprise\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            "Activity 1",
            "Activity 2",
            "Activity 3",
            "Activity 4",
            "Activity 5",
            "Activity 6",
            "Activity 7",
            "Activity 8",
            "Activity 9",
            "Activity 10",
            "Activity 11",
            "Activity 12",
            "Activity 13",
            "Activity 14",
            "Activity 15"
        ];

        foreach ($activities as $activity) {
            Activity::create(['activity' => $activity]);
        }
    }
}
