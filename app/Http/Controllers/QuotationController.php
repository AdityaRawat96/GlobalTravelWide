<?php

namespace App\Http\Controllers;

use App\Exports\QuotationsExport;
use App\Models\Quotation;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Airline;
use App\Models\Attachment;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Hotel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Quotation::class);
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
            $query = Quotation::leftJoin('customers', 'quotations.customer_id', '=', 'customers.id')
                ->select(
                    'quotations.id',
                    'quotations.quotation_id',
                    DB::raw("CONCAT('" . env('APP_SHORT', 'TW') . "', LPAD(quotations.user_id, 5, '0')) as user_id"),
                    DB::raw("IFNULL(CONCAT('C', LPAD(invoices.customer_id, 5, '0')), 'N/A') as customer_id"),
                    DB::raw("IFNULL(customers.name, 'N/A') as customer_name"),
                    DB::raw("DATE_FORMAT(quotations.quotation_date, '%d-%m-%Y') as quotation_date"),
                    'quotations.price',
                );

            // Check if the user is not an admin
            // if (auth()->user()->role != 'admin') {
            //     $query->where('quotations.user_id', auth()->user()->id);
            // }

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
                ->with('recordsTotal', Quotation::count())
                ->with('sqlQuery', $query->toSql()) // Note: It's better to use ->toSql() to get the SQL query for debugging purposes
                ->with('recordsFiltered', $recordsFiltered)
                ->addColumn('id', function ($data) {
                    return $data->id;
                })
                ->addColumn('added_by', function ($data) {
                    return env('APP_SHORT') . str_pad($data->added_by, 5, '0', STR_PAD_LEFT);
                })
                ->make(true);
            return $datatable;
        }
        $companies = Company::select('id', 'name')->get();
        return view('quotation.index')->with(['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Quotation::class);
        // return the view for creating a new quotation
        $companies = Company::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        return view('quotation.create')->with(['companies' => $companies, 'customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuotationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuotationRequest $request)
    {
        $this->authorize('create', Quotation::class);
        // Get the validated data from the request
        $validated = $request->validated();

        if (isset($validated['airline_name'])) {
            $airline_name = $validated['airline_name'];
            unset($validated['airline_name']);
            $departure_airport = $validated['departure_airport'];
            unset($validated['departure_airport']);
            $arrival_airport = $validated['arrival_airport'];
            unset($validated['arrival_airport']);
            $departure_time = $validated['departure_time'];
            unset($validated['departure_time']);
            $arrival_time = $validated['arrival_time'];
            unset($validated['arrival_time']);

            // Check if the airline_name, departure_airport, arrival_airport, departure_time and arrival_time are of the same length
            if (count($airline_name) != count($departure_airport) || count($airline_name) != count($arrival_airport) || count($airline_name) != count($departure_time) || count($airline_name) != count($arrival_time)) {
                return response()->json(['error' => 'The airline name, departure airport, arrival airport, departure time and arrival time must be of the same length'], 400);
            }
        }

        if (isset($validated['hotel_name'])) {
            $hotel_name = $validated['hotel_name'];
            unset($validated['hotel_name']);
            $checkin_time = $validated['checkin_time'];
            unset($validated['checkin_time']);
            $checkout_time = $validated['checkout_time'];
            unset($validated['checkout_time']);

            // Check if the hotel_name, checkin_time and checkout_time are of the same length
            if (count($hotel_name) != count($checkin_time) || count($hotel_name) != count($checkout_time)) {
                return response()->json(['error' => 'The hotel name, checkin time and checkout time must be of the same length'], 400);
            }
        }

        try {
            DB::beginTransaction();

            $validated['user_id'] = auth()->user()->id;
            // Store the quotation in the database
            $quotation = Quotation::create($validated);

            // Store quotation airline details
            if (isset($airline_name)) {
                foreach ($airline_name as $key => $name) {
                    $airline = [
                        'quotation_id' => $quotation->id,
                        'name' => $name,
                        'departure_airport' => $departure_airport[$key],
                        'arrival_airport' => $arrival_airport[$key],
                        'departure_time' => $departure_time[$key],
                        'arrival_time' => $arrival_time[$key]
                    ];
                    Airline::create($airline);
                }
            }

            // Store quotation hotel details
            if (isset($hotel_name)) {
                foreach ($hotel_name as $key => $name) {
                    $hotel = [
                        'quotation_id' => $quotation->id,
                        'name' => $name,
                        'checkin_time' => $checkin_time[$key],
                        'checkout_time' => $checkout_time[$key]
                    ];
                    Hotel::create($hotel);
                }
            }

            // Store quotation attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach ($files as $file) {
                    $attachment['type'] = 'quotation';
                    $attachment['ref_id'] = $quotation->id;
                    $attachment['name'] = $file->getClientOriginalName();
                    $attachment['extension'] = $file->getClientOriginalExtension();
                    $attachment['mime_type'] = $file->getClientMimeType();
                    $attachment['size'] = $file->getSize();
                    $attachment['url'] = $file->store('quotations', 'public');
                    Attachment::create($attachment);
                }
            }
            DB::commit();

            // Return the quotation
            return response()->json([
                'quotation' => $quotation,
                'message' => 'Quotation - ' . $quotation->quotation_id . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        $this->authorize('view', $quotation, Quotation::class);
        // return the view for showing the quotation
        $quotation_attachments = Attachment::where('type', 'quotation')->where('ref_id', $quotation->id)->get();
        $quotation_airlines = Airline::where('quotation_id', $quotation->id)->get();
        $quotation_hotels = Hotel::where('quotation_id', $quotation->id)->get();
        return view('quotation.show')->with(['quotation' => $quotation, 'quotation_attachments' => $quotation_attachments, 'quotation_airlines' => $quotation_airlines, 'quotation_hotels' => $quotation_hotels]);
    }


    public function showPdf(Request $request, $id)
    {
        $quotation = Quotation::where('id', $id)->first();
        $this->authorize('view', $quotation, Quotation::class);
        // return the view for showing the quotation
        $quotation_airlines = Airline::where('quotation_id', $quotation->id)->get();
        $quotation_hotels = Hotel::where('quotation_id', $quotation->id)->get();
        $pdf = Pdf::loadView('pdf.quotation', ['quotation' => $quotation, 'quotation_airlines' => $quotation_airlines, 'quotation_hotels' => $quotation_hotels, 'view' => false]);
        return $pdf->download($quotation->quotation_id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        $this->authorize('view', $quotation, Quotation::class);
        // return the view for editing the quotation
        $companies = Company::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        $quotation_airlines = Airline::where('quotation_id', $quotation->id)->get();
        $quotation_hotels = Hotel::where('quotation_id', $quotation->id)->get();
        $quotation_attachments = Attachment::where('type', 'quotation')->where('ref_id', $quotation->id)->get();
        foreach ($quotation_airlines as $index => $airline) {
            $quotation_airlines[$index]['airline_time'] = date("d-m-Y H:i", strtotime($airline->departure_time)) . ' - ' . date("d-m-Y H:i", strtotime($airline->arrival_time));
        }
        foreach ($quotation_hotels as $index => $hotel) {
            $quotation_hotels[$index]['hotel_time'] = date("d-m-Y H:i", strtotime($hotel->checkin_time)) . ' - ' . date("d-m-Y H:i", strtotime($hotel->checkout_time));
        }
        return view('quotation.create')->with(
            [
                'companies' => $companies,
                'customers' => $customers,
                'quotation' => $quotation,
                'quotation_airlines' => $quotation_airlines,
                'quotation_hotels' => $quotation_hotels,
                'quotation_attachments' => $quotation_attachments
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuotationRequest  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {

        $this->authorize('update', $quotation, Quotation::class);
        // Get the validated data from the request
        $validated = $request->validated();

        if (isset($validated['airline_name'])) {
            $airline_name = $validated['airline_name'];
            unset($validated['airline_name']);
            $departure_airport = $validated['departure_airport'];
            unset($validated['departure_airport']);
            $arrival_airport = $validated['arrival_airport'];
            unset($validated['arrival_airport']);
            $departure_time = $validated['departure_time'];
            unset($validated['departure_time']);
            $arrival_time = $validated['arrival_time'];
            unset($validated['arrival_time']);

            // Check if the airline_name, departure_airport, arrival_airport, departure_time and arrival_time are of the same length
            if (count($airline_name) != count($departure_airport) || count($airline_name) != count($arrival_airport) || count($airline_name) != count($departure_time) || count($airline_name) != count($arrival_time)) {
                return response()->json(['error' => 'The airline name, departure airport, arrival airport, departure time and arrival time must be of the same length'], 400);
            }
        }

        if (isset($validated['hotel_name'])) {
            $hotel_name = $validated['hotel_name'];
            unset($validated['hotel_name']);
            $checkin_time = $validated['checkin_time'];
            unset($validated['checkin_time']);
            $checkout_time = $validated['checkout_time'];
            unset($validated['checkout_time']);

            // Check if the hotel_name, checkin_time and checkout_time are of the same length
            if (count($hotel_name) != count($checkin_time) || count($hotel_name) != count($checkout_time)) {
                return response()->json(['error' => 'The hotel name, checkin time and checkout time must be of the same length'], 400);
            }
        }

        try {
            DB::beginTransaction();

            // Update the quotation in the database
            $quotation->update($validated);

            // Update quotation airline details
            Airline::where('quotation_id', $quotation->id)->delete();
            if (isset($airline_name)) {
                foreach ($airline_name as $key => $name) {
                    $airline = [
                        'quotation_id' => $quotation->id,
                        'name' => $name,
                        'departure_airport' => $departure_airport[$key],
                        'arrival_airport' => $arrival_airport[$key],
                        'departure_time' => $departure_time[$key],
                        'arrival_time' => $arrival_time[$key]
                    ];
                    Airline::create($airline);
                }
            }

            // Update quotation hotel details
            Hotel::where('quotation_id', $quotation->id)->delete();
            if (isset($hotel_name)) {
                foreach ($hotel_name as $key => $name) {
                    $hotel = [
                        'quotation_id' => $quotation->id,
                        'name' => $name,
                        'checkin_time' => $checkin_time[$key],
                        'checkout_time' => $checkout_time[$key]
                    ];
                    Hotel::create($hotel);
                }
            }

            $existing_files = Attachment::where('type', 'quotation')->where('ref_id', $quotation->id)->get();

            // Store quotation attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                // check file by name. if file exists, do not reupload and create an attachment, if the file is not in the request but in db delete the file and attachment
                foreach ($files as $file) {
                    $existing_file = $existing_files->where('name', $file->getClientOriginalName())->first();
                    if (!$existing_file) {
                        $attachment['type'] = 'quotation';
                        $attachment['ref_id'] = $quotation->id;
                        $attachment['name'] = $file->getClientOriginalName();
                        $attachment['extension'] = $file->getClientOriginalExtension();
                        $attachment['mime_type'] = $file->getClientMimeType();
                        $attachment['size'] = $file->getSize();
                        $attachment['url'] = $file->store('quotations', 'public');
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



            // Return the quotation
            return response()->json([
                'quotation' => $quotation,
                'message' => 'Quotation - ' . $quotation->quotation_id . ' updated successfully!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        $this->authorize('delete', $quotation, Quotation::class);
        try {
            DB::beginTransaction();

            // Delete the quotation airlines
            Airline::where('quotation_id', $quotation->id)->delete();
            // Delete the quotation hotels
            Hotel::where('quotation_id', $quotation->id)->delete();
            // Delete the quotation attachments
            $attachments = Attachment::where('type', 'quotation')->where('ref_id', $quotation->id)->get();
            foreach ($attachments as $attachment) {
                Storage::disk('public')->delete($attachment->url);
                $attachment->delete();
            }
            // Delete the quotation
            $quotation->delete();
            DB::commit();
            return response()->json(['message' => 'Quotation - ' . $quotation->quotation_id . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the quotations to excel
    public function export(Request $request, $type = 'excel')
    {
        $data = [
            'date' => $request->date,
            'company' =>  $request->company
        ];
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new QuotationsExport($data), 'quotations_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new QuotationsExport($data), 'quotations_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new QuotationsExport($data), 'quotations_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}
