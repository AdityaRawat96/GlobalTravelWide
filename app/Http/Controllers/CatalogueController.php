<?php

namespace App\Http\Controllers;

use App\Exports\CataloguesExport;
use App\Models\Catalogue;
use App\Http\Requests\StoreCatalogueRequest;
use App\Http\Requests\UpdateCatalogueRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Catalogue::class);
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
            $query = Catalogue::select(
                'id',
                'name',
                'status',
                'description',
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
                ->with('recordsTotal', Catalogue::count())
                ->with('sqlQuery', $query->get())
                ->with('recordsFiltered', $recordsFiltered)
                ->addColumn('id', function ($data) {
                    return str_pad($data->id, 5, '0', STR_PAD_LEFT);
                })
                ->addColumn('status', function ($data) {
                    return $data->status == 'active' ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->rawColumns(['status'])
                ->make(true);
            return $datatable;
        }
        return view('catalogue.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Catalogue::class);
        // return the view for creating a new catalogue
        return view('catalogue.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCatalogueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCatalogueRequest $request)
    {
        $this->authorize('create', Catalogue::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            // Store the catalogue in the database
            $catalogue = Catalogue::create($validated);
            DB::commit();
            // Return the catalogue

            return response()->json([
                'catalogue' => $catalogue,
                'message' => 'Catalogue - ' . str_pad($catalogue->id, 5, '0', STR_PAD_LEFT) . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catalogue  $catalogue
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Catalogue $catalogue)
    {
        $this->authorize('view', $catalogue, Catalogue::class);
        // Check if the request is ajax
        if ($request->ajax()) {
            // return the customer as json
            return response()->json($catalogue);
        }
        // return the view for showing the catalogue
        return view('catalogue.show', compact('catalogue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catalogue  $catalogue
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalogue $catalogue)
    {
        $this->authorize('view', $catalogue, Catalogue::class);
        // return the view for editing the catalogue
        return view('catalogue.create', compact('catalogue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCatalogueRequest  $request
     * @param  \App\Models\Catalogue  $catalogue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCatalogueRequest $request, Catalogue $catalogue)
    {
        $this->authorize('update', $catalogue, Catalogue::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            // Update the catalogue in the database
            $catalogue->update($validated);
            DB::commit();
            return response()->json(['message' => 'Catalogue - ' . str_pad($catalogue->id, 5, '0', STR_PAD_LEFT) . ' updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catalogue  $catalogue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalogue $catalogue)
    {
        $this->authorize('delete', $catalogue, Catalogue::class);
        try {
            DB::beginTransaction();
            $catalogue->delete();
            DB::commit();
            return response()->json(['message' => 'Catalogue - ' . str_pad($catalogue->id, 5, '0', STR_PAD_LEFT) . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the catalogues to excel
    public function export($type = 'excel')
    {
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new CataloguesExport, 'catalogues_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new CataloguesExport, 'catalogues_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new CataloguesExport, 'catalogues_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}
