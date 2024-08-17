<?php

use App\Models\Customer;
use App\Models\Query;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueryTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('query')->orderBy('id')->chunk(1000, function ($queries) {
            foreach ($queries as $query) {
                $customer_id = Customer::where('phone', $query->customerContact)->first()->id;
                try {
                    // Create a new model instance
                    $localQuery = new Query();
                    $localQuery->id = (int) $query->id;
                    $localQuery->user_id = (int) $query->employeeID;
                    $localQuery->customer_id = $customer_id;
                    $localQuery->date = $query->queryDate;
                    $localQuery->notes = $query->queryDescription;
                    $localQuery->status = $query->queryStatus;
                    $localQuery->save();
                } catch (\PDOException $e) {
                    if ($e->getCode() == '23000' && strpos($e->getMessage(), '1452') !== false) {
                        // Foreign key constraint violation, map added_by to id 1
                        Log::warning('Foreign key constraint violation for query ID ' . $query->id . '. Mapping added_by to ID 1.');
                        $localQuery->user_id = 1;
                        $localQuery->save();
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
