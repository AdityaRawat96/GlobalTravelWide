<?php

namespace App\Http\Controllers;

use App\Exports\QueriesExport;
use App\Models\Query;
use App\Http\Requests\StoreQueryRequest;
use App\Http\Requests\UpdateQueryRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class QueryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Query::class);
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
            $query = Query::join('customers', 'queries.customer_id', '=', 'customers.id')
                ->select(
                    'queries.id',
                    DB::raw("CONCAT('" . env('APP_SHORT', 'TW') . "', LPAD(queries.user_id, 5, '0')) as user_id"),
                    'customers.name as customer_name',
                    'customers.phone as contact',
                    DB::raw("DATE_FORMAT(queries.date, '%d-%m-%Y') as date"),
                    'status'
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
                ->with('recordsTotal', Query::count())
                ->with('sqlQuery', $query->get())
                ->with('recordsFiltered', $recordsFiltered)
                ->addColumn('status', function ($data) {
                    if ($data->status == 'not sold') {
                        return '<span class="badge badge-danger">Not Sold</span>';
                    } else if ($data->status == 'sold') {
                        return '<span class="badge badge-success">Sold</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                })
                ->rawColumns(['status'])
                ->make(true);
            return $datatable;
        }
        return view('query.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Query::class);
        // return the view for creating a new query
        $customers = Customer::select('id', 'name')->get();
        return view('query.create')->with(['customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQueryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQueryRequest $request)
    {
        $this->authorize('create', Query::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $validated['user_id'] = auth()->user()->id;
            // Store the query in the database
            $query = Query::create($validated);
            DB::commit();
            // Return the query

            return response()->json([
                'query' => $query,
                'message' => 'Query - ' . str_pad($query->id, 5, '0', STR_PAD_LEFT) . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Query $query)
    {
        $this->authorize('view', $query, Query::class);
        // Check if the request is ajax
        if ($request->ajax()) {
            // return the query as json
            return response()->json($query);
        }
        // return the view for showing the query
        return view('query.show', compact('query'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function edit(Query $query)
    {
        $this->authorize('view', $query, Query::class);
        // return the view for editing the query
        $customers = Customer::select('id', 'name')->get();
        return view('query.create', compact('query'))->with(['customers' => $customers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQueryRequest  $request
     * @param  \App\Models\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQueryRequest $request, Query $query)
    {
        $this->authorize('update', $query, Query::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            // Update the query in the database
            $query->update($validated);
            DB::commit();
            return response()->json(['message' => 'Query - ' . str_pad($query->id, 5, '0', STR_PAD_LEFT) . ' updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function destroy(Query $query)
    {
        $this->authorize('delete', $query, Query::class);
        try {
            DB::beginTransaction();
            $query->delete();
            DB::commit();
            return response()->json(['message' => 'Query - ' . str_pad($query->id, 5, '0', STR_PAD_LEFT) . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the queries to excel
    public function export($type = 'excel')
    {
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new QueriesExport, 'queries_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new QueriesExport, 'queries_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new QueriesExport, 'queries_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}
