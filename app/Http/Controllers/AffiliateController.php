<?php

namespace App\Http\Controllers;

use App\Exports\AffiliatesExport;
use App\Models\Affiliate;
use App\Http\Requests\StoreAffiliateRequest;
use App\Http\Requests\UpdateAffiliateRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Affiliate::class);
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
            $query = Affiliate::select(
                'id',
                'name',
                'email',
                'phone',
                'added_by',
            );

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
                ->with('recordsTotal', Affiliate::count())
                ->with('sqlQuery', $query->get())
                ->with('recordsFiltered', $recordsFiltered)
                ->addColumn('id', function ($data) {
                    return "C" . str_pad($data->id, 5, '0', STR_PAD_LEFT);
                })
                ->addColumn('added_by', function ($data) {
                    return env('APP_SHORT') . str_pad($data->added_by, 5, '0', STR_PAD_LEFT);
                })
                ->make(true);
            return $datatable;
        }
        return view('affiliate.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Affiliate::class);
        $customers = Customer::select('id', 'name')->get();
        // return the view for creating a new affiliate
        return view('affiliate.create')->with(['customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAffiliateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAffiliateRequest $request)
    {
        $this->authorize('create', Affiliate::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $validated['added_by'] = auth()->user()->id;
            // Store the affiliate in the database
            $affiliate = Affiliate::create($validated);
            DB::commit();
            // Return the affiliate

            return response()->json([
                'affiliate' => $affiliate,
                'message' => 'Affiliate - C' . str_pad($affiliate->id, 5, '0', STR_PAD_LEFT) . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Affiliate $affiliate)
    {
        $this->authorize('view', $affiliate, Affiliate::class);
        // Check if the request is ajax
        if ($request->ajax()) {
            // return the affiliate as json
            return response()->json($affiliate);
        }
        // return the view for showing the affiliate
        return view('affiliate.show', compact('affiliate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function edit(Affiliate $affiliate)
    {
        $this->authorize('view', $affiliate, Affiliate::class);
        // return the view for editing the affiliate
        return view('affiliate.create', compact('affiliate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAffiliateRequest  $request
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAffiliateRequest $request, Affiliate $affiliate)
    {
        $this->authorize('update', $affiliate, Affiliate::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            // Update the affiliate in the database
            $affiliate->update($validated);
            DB::commit();
            return response()->json(['message' => 'Affiliate - C' . str_pad($affiliate->id, 5, '0', STR_PAD_LEFT) . ' updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Affiliate $affiliate)
    {
        $this->authorize('delete', $affiliate, Affiliate::class);
        try {
            DB::beginTransaction();
            $affiliate->delete();
            DB::commit();
            return response()->json(['message' => 'Affiliate - C' . str_pad($affiliate->id, 5, '0', STR_PAD_LEFT) . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the affiliates to excel
    public function export($type = 'excel')
    {
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new AffiliatesExport, 'affiliates_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new AffiliatesExport, 'affiliates_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new AffiliatesExport, 'affiliates_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}