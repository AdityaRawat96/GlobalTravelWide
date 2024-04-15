<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        $role = Role::create([
            'name' => 'staff',
            'guard_name' => 'web'
        ]);
        $role = Role::create([
            'name' => 'other',
            'guard_name' => 'web'
        ]);
    }
}
