<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['USER', 'ADMINISTRATOR'];

        $faker = Faker::create();

        foreach ($roles as $role) {
            \App\Models\Role::create([
                'name' => $role,
                'guard_name' => 'api',
            ]);
        }
    }
}
