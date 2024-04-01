<?php

namespace App\Http\Controllers;

use App\Exports\ExpensesExport;
use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Attachment;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Expense::class);
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
            $query = Expense::select(
                'id',
                DB::raw("DATE_FORMAT(date, '%d-%m-%Y') as date"),
                'amount',
                'description',
            );

            // only if the filter is not empty and exists filter the records
            if (!empty($request->filter) && isset($request->filter)) {
                $start_date = $request->filter['start_date'];
                $end_date = $request->filter['end_date'];
                $query->where('date', '>=', $start_date)->where('date', '<=', $end_date);
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

            $total_expenses = $data_filtered->sum('amount');

            $datatable = DataTables::of($data_filtered)
                ->setOffset($start)
                ->with('expenseTotal', $total_expenses)
                ->with('recordsTotal', Expense::count())
                ->with('sqlQuery', $query->get())
                ->with('recordsFiltered', $recordsFiltered)
                ->make(true);
            return $datatable;
        }
        return view('expense.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Expense::class);
        // return the view for creating a new expense
        $customers = Customer::select('id', 'name')->get();
        return view('expense.create')->with(['customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseRequest $request)
    {
        $this->authorize('create', Expense::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $validated['user_id'] = auth()->user()->id;
            // Store the expense in the database
            $expense = Expense::create($validated);

            // Store expense attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach ($files as $file) {
                    $attachment['type'] = 'expense';
                    $attachment['ref_id'] = $expense->id;
                    $attachment['name'] = $file->getClientOriginalName();
                    $attachment['extension'] = $file->getClientOriginalExtension();
                    $attachment['mime_type'] = $file->getClientMimeType();
                    $attachment['size'] = $file->getSize();
                    $attachment['url'] = $file->store('expenses', 'public');
                    Attachment::create($attachment);
                }
            }
            DB::commit();
            // Return the expense

            return response()->json([
                'expense' => $expense,
                'message' => 'Expense - ' . str_pad($expense->id, 5, '0', STR_PAD_LEFT) . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Expense $expense)
    {
        $this->authorize('view', $expense, Expense::class);
        $expense_attachments = Attachment::where('type', 'expense')->where('ref_id', $expense->id)->get();
        // return the view for showing the expense
        return view('expense.show', compact('expense'))->with(['expense_attachments' => $expense_attachments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $this->authorize('view', $expense, Expense::class);
        // return the view for editing the expense
        $expense_attachments = Attachment::where('type', 'expense')->where('ref_id', $expense->id)->get();
        return view('expense.create', compact('expense'))->with(['expense_attachments' => $expense_attachments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpenseRequest  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense, Expense::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            // Update the expense in the database
            $expense->update($validated);
            $existing_files = Attachment::where('type', 'expense')->where('ref_id', $expense->id)->get();

            // Store expense attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                // check file by name. if file exists, do not reupload and create an attachment, if the file is not in the request but in db delete the file and attachment
                foreach ($files as $file) {
                    $existing_file = $existing_files->where('name', $file->getClientOriginalName())->first();
                    if (!$existing_file) {
                        $attachment['type'] = 'expense';
                        $attachment['ref_id'] = $expense->id;
                        $attachment['name'] = $file->getClientOriginalName();
                        $attachment['extension'] = $file->getClientOriginalExtension();
                        $attachment['mime_type'] = $file->getClientMimeType();
                        $attachment['size'] = $file->getSize();
                        $attachment['url'] = $file->store('expenses', 'public');
                        Attachment::create($attachment);
                    }
                }

                // Delete the files that are not in the request
                foreach ($existing_files as $existing_file) {
                    $file_exists = false;
                    foreach ($files as $file) {
                        if ($existing_file->name == $file->getClientOriginalName()) {
                            $file_exists = true;
                            break;
                        }
                    }
                    if (!$file_exists) {
                        Storage::disk('public')->delete($existing_file->url);
                        $existing_file->delete();
                    }
                }
            } else {
                // Delete all the files if no file is in the request
                foreach ($existing_files as $existing_file) {
                    Storage::disk('public')->delete($existing_file->url);
                    $existing_file->delete();
                }
            }
            DB::commit();
            return response()->json(['message' => 'Expense - ' . str_pad($expense->id, 5, '0', STR_PAD_LEFT) . ' updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense, Expense::class);
        try {
            DB::beginTransaction();
            // Delete the expense attachments
            $attachments = Attachment::where('type', 'expense')->where('ref_id', $expense->id)->get();
            foreach ($attachments as $attachment) {
                Storage::disk('public')->delete($attachment->url);
                $attachment->delete();
            }
            $expense->delete();
            DB::commit();
            return response()->json(['message' => 'Expense - ' . str_pad($expense->id, 5, '0', STR_PAD_LEFT) . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the expenses to excel
    public function export(Request $request, $type = 'excel')
    {
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new ExpensesExport($data), 'expenses_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new ExpensesExport($data), 'expenses_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new ExpensesExport($data), 'expenses_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}
