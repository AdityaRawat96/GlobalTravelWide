<?php

namespace App\Http\Controllers;

use App\Exports\PnrsExport;
use App\Models\Pnr;
use App\Http\Requests\StorePnrRequest;
use App\Http\Requests\UpdatePnrRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class PnrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Pnr::class);
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
            $query = Pnr::select(
                'id',
                DB::raw("CONCAT('" . env('APP_SHORT', 'TW') . "', LPAD(user_id, 5, '0')) as user_id"),
                'number',
                DB::raw("DATE_FORMAT(pnrs.date, '%d-%m-%Y %h:%i %p') as date"),
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
                // Loop columns and if they are searchable then add a where clause for first one and orWhere for the rest. if name exists whose values is an array loop that array and add the items to search
                $column_searched = false;
                foreach ($columns as $column) {
                    if ($column['searchable'] == 'true') {
                        if (!$column_searched) {
                            $query->where($column['data'], 'like', '%' . $search['value'] . '%');
                            $column_searched = true;
                        } else {
                            $query->orWhere($column['data'], 'like', '%' . $search['value'] . '%');
                        }
                    }
                }
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
                ->with('recordsTotal', Pnr::count())
                ->with('sqlQuery', $query->get())
                ->with('recordsFiltered', $recordsFiltered)
                ->addColumn('status', function ($data) {
                    if ($data->status == 'cancelled') {
                        return '<span class="badge badge-danger">Cancelled</span>';
                    } else if ($data->status == 'issued') {
                        return '<span class="badge badge-success">Issued</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                })
                ->rawColumns(['status'])
                // add column for raw value of status
                ->addColumn('status_raw', function ($data) {
                    return $data->status;
                })
                ->make(true);
            return $datatable;
        }
        return view('pnr.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Pnr::class);
        // return the view for creating a new pnr
        return view('pnr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePnrRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePnrRequest $request)
    {
        $this->authorize('create', Pnr::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $validated['user_id'] = auth()->user()->id;
            // Store the pnr in the database
            $pnr = Pnr::create($validated);
            DB::commit();
            // Return the pnr

            return response()->json([
                'pnr' => $pnr,
                'message' => 'Pnr - ' . str_pad($pnr->id, 5, '0', STR_PAD_LEFT) . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Pnr $pnr)
    {
        $this->authorize('view', $pnr, Pnr::class);
        // Check if the request is ajax
        if ($request->ajax()) {
            // return the pnr as json
            return response()->json($pnr);
        }
        // return the view for showing the pnr
        return view('pnr.show', compact('pnr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Http\Response
     */
    public function edit(Pnr $pnr)
    {
        $this->authorize('view', $pnr, Pnr::class);
        // return the view for editing the pnr
        return view('pnr.create', compact('pnr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePnrRequest  $request
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePnrRequest $request, Pnr $pnr)
    {
        $this->authorize('update', $pnr, Pnr::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            // Update the pnr in the database
            $pnr->update($validated);
            DB::commit();
            return response()->json(['message' => 'Pnr - ' . str_pad($pnr->id, 5, '0', STR_PAD_LEFT) . ' updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pnr $pnr)
    {
        $this->authorize('delete', $pnr, Pnr::class);
        try {
            DB::beginTransaction();
            $pnr->delete();
            DB::commit();
            return response()->json(['message' => 'Pnr - ' . str_pad($pnr->id, 5, '0', STR_PAD_LEFT) . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the pnrs to excel
    public function export($type = 'excel')
    {
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new PnrsExport, 'pnrs_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new PnrsExport, 'pnrs_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new PnrsExport, 'pnrs_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}