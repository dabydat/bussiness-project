<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(ActivitiesTableSeeder::class);
        $this->call(EnterpriseTableSeeder::class);
        $this->call(EnterpriseActivitiesTableSeeder::class);
    }
}
