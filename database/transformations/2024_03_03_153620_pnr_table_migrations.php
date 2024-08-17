<?php

use App\Models\Pnr;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PnrTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('pnr')->orderBy('id')->chunk(1000, function ($pnrs) {
            foreach ($pnrs as $pnr) {
                try {
                    // Create a new model instance
                    $localPnr = new Pnr();
                    $localPnr->id = (int) $pnr->id;
                    $localPnr->user_id = (int) $pnr->employeeID;
                    $localPnr->number = $pnr->PNRNumber;
                    $localPnr->date = $pnr->PNRDate;
                    $localPnr->notes = $pnr->PNRDescription;
                    $localPnr->status = $pnr->PNRStatus;
                    $localPnr->save();
                } catch (\PDOException $e) {
                    if ($e->getCode() == '23000' && strpos($e->getMessage(), '1452') !== false) {
                        // Foreign key constraint violation, map added_by to id 1
                        Log::warning('Foreign key constraint violation for pnr ID ' . $pnr->id . '. Mapping added_by to ID 1.');
                        $localPnr->user_id = 1;
                        $localPnr->save();
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
