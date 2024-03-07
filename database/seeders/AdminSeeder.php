<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'role' => 'admin',
            'first_name' => env('ADMIN_FIRST_NAME'),
            'last_name' => env('ADMIN_LAST_NAME'),
            'phone' => '',
            'email' => env('ADMIN_EMAIL'),
            'username' => env('ADMIN_USERNAME'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('admin');

        UserData::create([
            'user_id' => $user->id
        ]);
    }
}
