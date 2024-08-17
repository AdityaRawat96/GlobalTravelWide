<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('user')->orderBy('id')->chunk(1000, function ($users) {
            foreach ($users as $user) {
                // Create a new model instance
                $localUser = new User();
                $localUser->id = (int) $user->id;
                $localUser->role = $user->userType == 0 ? 'admin' : 'staff';
                $localUser->first_name = $user->fname;
                $localUser->last_name = $user->lname;
                $localUser->phone = $user->phone;
                $localUser->email = $user->email;
                $localUser->username = $user->username;
                $localUser->password = Hash::make($user->password);
                $localUser->email_verified_at = now();
                $localUser->save();
            }
        });
    }

    public function down()
    {
        // Revert the migration (optional)
    }
}
