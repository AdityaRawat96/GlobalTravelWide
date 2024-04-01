<?php

namespace App\Http\Controllers;

use App\Exports\RemindersExport;
use App\Models\Reminder;
use App\Http\Requests\StoreReminderRequest;
use App\Http\Requests\UpdateReminderRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Reminder::class);
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
            $query = Reminder::join('customers', 'reminders.customer_id', '=', 'customers.id')
                ->select(
                    'reminders.id',
                    DB::raw("CONCAT('" . env('APP_SHORT', 'TW') . "', LPAD(reminders.user_id, 5, '0')) as user_id"),
                    'customers.name as customer_name',
                    DB::raw("DATE_FORMAT(reminders.date, '%d-%m-%Y %h:%i %p') as date"),
                );

            // only if the filter is not empty and exists filter the records
            if (!empty($request->filter) && isset($request->filter)) {
                foreach ($request->filter as $filter) {
                    if ($filter['type'] == 'text') {
                        $query->where($filter['name'], $filter['comparator'], $filter['value']);
                    } else if ($filter['type'] == 'date') {
                        $query->whereDate($filter['name'], $filter['comparator'], $filter['value']);
                    }
                }
            }

            // Add the search query trim the search value and check if it is not empty
            if (!empty($search['value'])) {
                $query->where(function ($query) use ($columns, $search) {
                    $query->where('customers.name', 'like', '%' . $search['value'] . '%');
                    foreach ($columns as $column) {
                        if ($column['searchable'] == 'true' && $column['data'] != 'customer_name') {
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
                ->with('recordsTotal', Reminder::count())
                ->with('sqlQuery', $query->get())
                ->with('recordsFiltered', $recordsFiltered)
                ->make(true);
            return $datatable;
        }
        return view('reminder.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Reminder::class);
        // return the view for creating a new reminder
        $customers = Customer::select('id', 'name')->get();
        return view('reminder.create')->with(['customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReminderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReminderRequest $request)
    {
        $this->authorize('create', Reminder::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $validated['user_id'] = auth()->user()->id;
            // Store the reminder in the database
            $reminder = Reminder::create($validated);
            DB::commit();
            // Return the reminder

            return response()->json([
                'reminder' => $reminder,
                'message' => 'Reminder - ' . str_pad($reminder->id, 5, '0', STR_PAD_LEFT) . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Reminder $reminder)
    {
        $this->authorize('view', $reminder, Reminder::class);
        // Check if the request is ajax
        if ($request->ajax()) {
            // return the reminder as json
            return response()->json($reminder);
        }
        // return the view for showing the reminder
        return view('reminder.show', compact('reminder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function edit(Reminder $reminder)
    {
        $this->authorize('view', $reminder, Reminder::class);
        // return the view for editing the reminder
        $customers = Customer::select('id', 'name')->get();
        return view('reminder.create', compact('reminder'))->with(['customers' => $customers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReminderRequest  $request
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReminderRequest $request, Reminder $reminder)
    {
        $this->authorize('update', $reminder, Reminder::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            // Update the reminder in the database
            $reminder->update($validated);
            DB::commit();
            return response()->json(['message' => 'Reminder - ' . str_pad($reminder->id, 5, '0', STR_PAD_LEFT) . ' updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder, Reminder::class);
        try {
            DB::beginTransaction();
            $reminder->delete();
            DB::commit();
            return response()->json(['message' => 'Reminder - ' . str_pad($reminder->id, 5, '0', STR_PAD_LEFT) . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the reminders to excel
    public function export($type = 'excel')
    {
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new RemindersExport, 'reminders_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new RemindersExport, 'reminders_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new RemindersExport, 'reminders_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}
