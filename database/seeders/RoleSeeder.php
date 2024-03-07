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
            'name' => 'digital',
            'guard_name' => 'web'
        ]);
        $role = Role::create([
            'name' => 'marketing',
            'guard_name' => 'web'
        ]);
    }
}
