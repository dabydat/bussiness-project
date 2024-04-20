<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = Role::create(['name' => 'administrator']);
        $normal = Role::create(['name' => 'normal']);
        Permission::create(['name' => 'user.changeRole'])->syncRoles(['administrator']);
        Permission::create(['name' => 'enterprise.asociateActivity'])->syncRoles(['administrator']);
        Permission::create(['name' => 'enterprise.disasociateActivity'])->syncRoles(['administrator']);
    }
}
