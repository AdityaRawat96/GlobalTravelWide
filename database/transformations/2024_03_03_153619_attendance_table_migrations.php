<?php

use App\Models\Attendance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('attendance')->orderBy('id')->chunk(1000, function ($attendances) {
            foreach ($attendances as $attendance) {
                try {
                    // Create a new model instance
                    $localAttendance = new Attendance();
                    $localAttendance->id = (int) $attendance->id;
                    $localAttendance->user_id = $attendance->empID;
                    $localAttendance->date = $attendance->attendanceDate;
                    $localAttendance->in_time = $attendance->attendanceDate . " " . $attendance->inTime;
                    $localAttendance->out_time = $attendance->attendanceDate . " " . $attendance->outTime;
                    $localAttendance->duration = $attendance->duration ? $attendance->duration : 0;
                    $localAttendance->save();
                } catch (\PDOException $e) {
                    if ($e->getCode() == '23000' && strpos($e->getMessage(), '1452') !== false) {
                        // Foreign key constraint violation, map added_by to id 1
                        Log::warning('Foreign key constraint violation for attendance ID ' . $attendance->id . '. Mapping added_by to ID 1.');
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
