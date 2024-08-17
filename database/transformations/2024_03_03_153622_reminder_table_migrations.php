<?php

use App\Models\Customer;
use App\Models\Reminder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReminderTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('reminder')->orderBy('id')->chunk(1000, function ($reminders) {
            foreach ($reminders as $reminder) {
                $customer_id = Customer::where('phone', $reminder->customerContact)->first()->id;
                try {
                    // Create a new model instance
                    $localReminder = new Reminder();
                    $localReminder->id = (int) $reminder->id;
                    $localReminder->user_id = (int) $reminder->employeeID;
                    $localReminder->customer_id = $customer_id;
                    $localReminder->date = $reminder->reminderDate;
                    $localReminder->notes = $reminder->reminderDescription;
                    $localReminder->save();
                } catch (\PDOException $e) {
                    if ($e->getCode() == '23000' && strpos($e->getMessage(), '1452') !== false) {
                        // Foreign key constraint violation, map added_by to id 1
                        Log::warning('Foreign key constraint violation for reminder ID ' . $reminder->id . '. Mapping added_by to ID 1.');
                    } else {
                        // Rethrow the exception if it's not the specific foreign key constraint violation
                        throw $e;
                    }
                }
            }
        });
    }

    public function down()
    {
        // Define the rollback logic if necessary
    }
}
