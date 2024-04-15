<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\WelcomeEmail;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        // Check if the request is ajax
        if ($request->ajax()) {
            // Write your logic to get the data from database using the request object values

            // Get the values from the request object
            $start = $request->start;
            $length = $request->length;
            $search = $request->search;
            $order = $request->order;
            $columns = $request->columns;

            // Build an eloquent query using these values
            $query = User::select(
                'id',
                'first_name',
                'last_name',
                'role',
                'email',
                'phone',
                'status',
            );

            // Add the search query trim the search value and check if it is not empty
            if (!empty($search['value'])) {
                $query->where(function ($query) use ($columns, $search) {
                    $query->where('first_name', 'like', '%' . $search['value'] . '%');
                    $query->orWhere('last_name', 'like', '%' . $search['value'] . '%');
                    foreach ($columns as $column) {
                        if ($column['searchable'] == 'true' && $column['data'] != 'full_name') {
                            $query->orWhere($column['data'], 'like', '%' . $search['value'] . '%');
                        }
                    }
                });
            }

            // Add the order by clause if the column is orderable
            if (!empty($order)) {
                $column = $columns[$order[0]['column']]['data'];
                $dir = $order[0]['dir'];
                if ($columns[$order[0]['column']]['orderable'] == 'true') {
                    $query->orderBy($column, $dir);
                }
            }

            // get count of the records from query
            $recordsFiltered = $query->count();

            // Get the data
            $query->offset($start)
                ->limit($length);

            $data_filtered = $query->get();

            $datatable = DataTables::of($data_filtered)
                ->setOffset($start)
                ->with('recordsTotal', User::count())
                ->with('sqlQuery', $query->get())
                ->with('recordsFiltered', $recordsFiltered)
                ->addColumn('full_name', function ($data) {
                    return $data->first_name . ' ' . $data->last_name;
                })
                ->addColumn('id', function ($data) {
                    return env('APP_SHORT') . str_pad($data->id, 5, '0', STR_PAD_LEFT);
                })
                ->addColumn('role', function ($data) {
                    return ucfirst($data->role);
                })
                ->addColumn('status', function ($data) {
                    return $data->status == 'active' ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->rawColumns(['status'])
                ->make(true);
            return $datatable;
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        // return the view for creating a new user
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatar_file = $avatar->store('avatars', 'public');
            }

            // Create a strong password for the user of length 12 characters including at least one uppercase letter, one lowercase letter, one number and one special character
            $password = $this->str_random(12);
            $validated['password'] = bcrypt($password);
            $validated['avatar'] = $avatar_file ?? null;

            // Store the user in the database
            $user = User::create($validated);

            // create a unique username for the user using the id with a prefix TW and padding of 5 zeros
            $user->username = env('APP_SHORT') . str_pad($user->id, 5, '0', STR_PAD_LEFT);
            $user->save();
            $user->rawPassword = $password;

            // Send the user a welcome email
            Mail::to($user->email)->send(new WelcomeEmail($user));
            DB::commit();
            // Return the user
            unset($user->rawPassword);
            return response()->json([
                'user' => $user,
                'message' => 'User - ' . $user->username . ' created successfully! An email has been sent to the user with the login credentials.'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user, User::class);

        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        foreach ($attendances as $attendance) {
            $attendance->title = 'Attendance record for ' . date('d-m-Y', strtotime($attendance->date));
            $attendance->start = $attendance->date . 'T' . date('H:i:s', strtotime($attendance->in_time));
            if ($attendance->out_time) {
                $attendance->end = $attendance->date . 'T' . date('H:i:s', strtotime($attendance->out_time));
                $attendance->description = 'Duration: ' . $attendance->duration . ' minutes';
                $attendance->className = 'fc-event-success';
            } else {
                $attendance->description = 'Out time not marked yet';
                $attendance->className = 'fc-event-danger fc-event-solid-warning';
            }
            $attendance->location = 'London/UK';
        }

        // return the view for showing the user
        return view('user.show', compact('user', 'attendances'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('view', $user, User::class);
        // return the view for editing the user
        return view('user.create', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user, User::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatar_file = $avatar->store('avatars', 'public');
                $validated['avatar'] = $avatar_file;
            }

            // Update the user in the database
            $user->update($validated);
            DB::commit();
            return response()->json(['message' => 'User - ' . env('APP_SHORT') . str_pad($user->id, 5, '0', STR_PAD_LEFT) . ' updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePassword(Request $request, $user_id = null)
    {
        if ($user_id == null) {
            $user_id = Auth::user()->id;
        }
        $user = User::where('id', $user_id)->first();
        $user_updated = User::where('id', $user->id)->update([
            'password' => Hash::make($request->all()["password"]),
        ]);
        if ($user_updated) {
            $data["success"] = true;
            $data["response"] = "Password updated successfully!";
        } else {
            $data["success"] = false;
            $data["response"] = "There was an error in updating your profile. Please try again!";
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return response()->json(['message' => 'User - ' . env('APP_SHORT') . str_pad($user->id, 5, '0', STR_PAD_LEFT) . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            // Check if the error is due to foreign key constraint
            if (strpos($e->getMessage(), 'foreign key constraint fails')) {
                return response()->json(['error' => 'This user cannot be deleted because it is associated with other records.'], 500);
            }
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the users to excel
    public function export($type = 'excel')
    {
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new UsersExport, 'users_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new UsersExport, 'users_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new UsersExport, 'users_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }

    public function str_random($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}|:"<>?';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
