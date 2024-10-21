<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Http\Requests\UpdateUserAttendanceRequest;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        foreach ($attendances as $attendance) {
            $attendance->title = 'Attendance record for ' . date('d-m-Y', strtotime($attendance->date));
            $attendance->start = $attendance->date . 'T' . date('H:i:s', strtotime($attendance->in_time));
            if ($attendance->out_time) {
                $attendance->end = $attendance->date . 'T' . date('H:i:s', strtotime($attendance->out_time));
                if (isset($attendance->duration)) {
                    $hours = floor($attendance->duration / 60);
                    $minutes = $attendance->duration % 60;
                    $attendance->description = 'Duration: ' . $hours . ' hours ' . $minutes . ' minutes';
                }
                $attendance->className = 'fc-event-success';
            } else {
                $attendance->description = 'Out time not marked yet';
                $attendance->className = 'fc-event-danger fc-event-solid-warning';
            }
            $attendance->location = 'London/UK';
        }

        // Create a new DateTime object
        $currentDateTime = new DateTime();
        // Set the timezone to UK timezone
        $currentDateTime->setTimezone(new DateTimeZone('Europe/London'));
        // Format the date as per your requirements
        // $formattedDate = $currentDateTime->format('d-m-Y H:i:s');
        $formattedDate = $currentDateTime->format('d-m-Y');
        $currentDate = $currentDateTime->format('Y-m-d');

        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', $currentDate)
            ->first();

        if ($attendance) {
            // format in AM/PM
            $attendance->in_time = date('h:i A', strtotime($attendance->in_time));
            if ($attendance->out_time) {
                $attendance->out_time = date('h:i A', strtotime($attendance->out_time));
                // Duration in hours and minutes
                $hours = floor($attendance->duration / 60);
                $minutes = $attendance->duration % 60;
                $attendance->duration = $hours . ' hours ' . $minutes . ' minutes';
            }
        }

        return view('attendance.index')->with([
            'attendance' => $attendance,
            'attendances' => $attendances,
            'formattedDate' => $formattedDate
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRequest $request)
    {
        // Create a new DateTime object
        $currentDateTime = new DateTime();
        // Set the timezone to UK timezone
        $currentDateTime->setTimezone(new DateTimeZone('Europe/London'));
        // Format the date as per your requirements
        // $formattedDate = $currentDateTime->format('d-m-Y H:i:s');
        $formattedDate = $currentDateTime->format('Y-m-d');

        // Check if the user has already marked the attendance for the current date
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', $formattedDate)
            ->first();

        // If the user has already marked the attendance for the current date
        if ($attendance) {
            return response()->json(['error' => 'You have already marked the attendance for today.'], 500);
        }
        try {
            DB::beginTransaction();
            // Create a new Attendance instance
            $attendance = new Attendance();
            // Assign the values to the Attendance instance
            $attendance->user_id = Auth::id();
            $attendance->date = $formattedDate;
            $attendance->in_time = $currentDateTime->format('Y-m-d H:i:s');
            // Save the Attendance instance
            $attendance->save();

            DB::commit();
            // Return the attendance
            return response()->json([
                'attendance' => $attendance,
                'message' => 'Attendance marked successfully.'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendanceRequest  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $attendance = Attendance::find($attendance->id);
        // Create a new DateTime object
        $currentDateTime = new DateTime();
        // Set the timezone to UK timezone
        $currentDateTime->setTimezone(new DateTimeZone('Europe/London'));

        // If the user has already marked the attendance for the current date
        if ($attendance->out_time !== null) {
            return response()->json(['error' => 'You have already marked the attendance for today.'], 500);
        }

        try {
            DB::beginTransaction();
            // Assign the values to the Attendance instance
            $attendance->out_time = $currentDateTime->format('Y-m-d H:i:s');
            $interval = (new DateTime($attendance->in_time))->diff(new DateTime($attendance->out_time));
            $attendance->duration = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
            // Save the Attendance instance
            $attendance->save();

            DB::commit();
            // Return the attendance
            return response()->json([
                'attendance' => $attendance,
                'message' => 'Attendance marked successfully.'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateAttendance(UpdateUserAttendanceRequest $request, $user_id)
    {
        // Authorization check
        // Get the validated data from the request
        $validated = $request->validated();

        $attendance_date = $validated['date'];
        $in_time = $validated['in_time'];
        $out_time = $validated['out_time'];

        try {
            DB::beginTransaction();
            $attendance = Attendance::where('user_id', $user_id)
                ->where('date', $attendance_date)
                ->first();

            if (!$attendance) {
                $attendance = new Attendance();
                $attendance->user_id = $user_id;
                $attendance->date = $attendance_date;
            }
            $attendance->in_time = $in_time;
            $attendance->out_time = $out_time;
            $interval = (new DateTime($attendance->in_time))->diff(new DateTime($attendance->out_time));
            $attendance->duration = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
            $attendance->save();
            DB::commit();
            return response()->json(['message' => 'Attendance updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
