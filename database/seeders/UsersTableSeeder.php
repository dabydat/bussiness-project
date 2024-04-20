<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    private $formatTime = 'Y-m-d H:i:s';
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userAdmin = \App\Models\User::create(
            [
                "name" => 'Demo Name User',
                "email" => 'bussiness_project_user@example.com',
                "password" => Hash::make('12345678'),
                "email_verified_at" => null,
                "created_at" => $faker->dateTimeThisDecade->format($this->formatTime),
                "updated_at" => $faker->dateTimeThisDecade->format($this->formatTime),
                "phone_number" => $faker->phoneNumber,
                "local_number" => $faker->phoneNumber,
                "role_id" => 1,
                "rejected_change_role" => false
            ]
        );

        $userAdmin->assignRole('administrator');
        $userAdmin->syncPermissions(['user.changeRole', 'enterprise.asociateActivity', 'enterprise.disasociateActivity']);

        for ($i = 0; $i < 11; $i++) {
            $role_id = $faker->randomElement([1, 2]);
            $user = \App\Models\User::create(
                [
                    "name" => $faker->name,
                    "email" => $faker->unique()->safeEmail,
                    "password" => Hash::make('12345678'),
                    "email_verified_at" => null,
                    "created_at" => $faker->dateTimeThisDecade->format($this->formatTime),
                    "updated_at" => $faker->dateTimeThisDecade->format($this->formatTime),
                    "phone_number" => $faker->phoneNumber,
                    "local_number" => $faker->phoneNumber,
                    "role_id" => $role_id,
                    "rejected_change_role" => $role_id === 1 ? false : $faker->randomElement([true, false])
                ]
            );

            if ($role_id === 1) {
                $user->assignRole('administrator');
                $user->syncPermissions(['user.changeRole', 'enterprise.asociateActivity', 'enterprise.disasociateActivity']);
            }
        }

    }
}
