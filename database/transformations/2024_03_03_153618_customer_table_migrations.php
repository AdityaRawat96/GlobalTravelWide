<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('customer')->orderBy('id')->chunk(1000, function ($customers) {
            foreach ($customers as $customer) {
                try {
                    // Create a new model instance
                    $localCustomer = new Customer();
                    $localCustomer->id = (int) $customer->id;
                    $localCustomer->name = $customer->name;
                    $localCustomer->phone = $customer->phone;
                    $localCustomer->email = $customer->email;
                    $localCustomer->added_by = (int) $customer->addedBy;
                    $localCustomer->save();
                } catch (\PDOException $e) {
                    if ($e->getCode() == '23000' && strpos($e->getMessage(), '1452') !== false) {
                        // Foreign key constraint violation, map added_by to id 1
                        Log::warning('Foreign key constraint violation for customer ID ' . $customer->id . '. Mapping added_by to ID 1.');
                        $localCustomer->added_by = 1;
                        $localCustomer->save();
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
