<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $user = \App\Models\User::create(
            [
                "name" => $faker->name,
                "email" => $faker->email,
                "password" => Hash::make('12345678'),
                "email_verified_at" => null,
                "created_at" => $faker->dateTimeThisDecade->format('Y-m-d H:i:s'),
                "updated_at" => $faker->dateTimeThisDecade->format('Y-m-d H:i:s'),
                "phone_number" => $faker->phoneNumber,
                "local_number" => $faker->phoneNumber,
                "role_id" => 1,
                "rejected_change_role" => false
            ]
        );
        $user->assignRole('administrator');
        $user->syncPermissions(['user.changeRole', 'enterprise.asociateActivity', 'enterprise.disasociateActivity']);
    }
}
