<?php

namespace App\Http\Controllers;

use App\Exports\RefundsExport;
use App\Models\Refund;
use App\Http\Requests\StoreRefundRequest;
use App\Http\Requests\UpdateRefundRequest;
use App\Models\Attachment;
use App\Models\Catalogue;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Refund::class);
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
            $query = Refund::join('customers', 'refunds.customer_id', '=', 'customers.id')
                ->select(
                    'refunds.id',
                    'refunds.refund_id',
                    'refunds.status as status',
                    'refunds.ref_number',
                    DB::raw("CONCAT('" . env('APP_SHORT', 'TW') . "', LPAD(refunds.user_id, 5, '0')) as user_id"),
                    DB::raw("CONCAT('C', LPAD(refunds.customer_id, 5, '0')) as customer_id"),
                    'customers.name as customer_name',
                    DB::raw("DATE_FORMAT(refunds.refund_date, '%d-%m-%Y') as refund_date"),
                    'refunds.due_date',
                    'refunds.total',
                );

            // Check if the user is not an admin
            if (auth()->user()->role != 'admin') {
                $query->where('refunds.user_id', auth()->user()->id);
            }


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
                    $query->where('customer_name', 'like', '%' . $search['value'] . '%');
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
                ->with('recordsTotal', Refund::count())
                ->with('sqlQuery', $query->toSql()) // Note: It's better to use ->toSql() to get the SQL query for debugging purposes
                ->with('recordsFiltered', $recordsFiltered)
                ->addColumn('id', function ($data) {
                    return $data->id;
                })
                ->addColumn('added_by', function ($data) {
                    return env('APP_SHORT') . str_pad($data->added_by, 5, '0', STR_PAD_LEFT);
                })
                ->addColumn('total', function ($data) {
                    return number_format(($data->total), 2, '.', '');
                })
                ->addColumn('status', function ($data) {
                    if ($data->due_date < date('Y-m-d') && $data->status == 'pending') {
                        return '<span class="badge badge-danger">Overdue</span>';
                    } else if ($data->status == 'paid') {
                        return '<span class="badge badge-success">Paid</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                })
                ->rawColumns(['status'])
                ->make(true);
            return $datatable;
        }
        $companies = Company::select('id', 'name')->get();
        return view('refund.index')->with(['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Refund::class);
        // return the view for creating a new refund
        $companies = Company::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        $products = Catalogue::select('id', 'name')->where('status', 'active')->get();
        return view('refund.create')->with(['companies' => $companies, 'customers' => $customers, 'products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRefundRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRefundRequest $request)
    {
        $this->authorize('create', Refund::class);
        // Get the validated data from the request
        $validated = $request->validated();

        $products = $validated['product'];
        unset($validated['product']);
        $quantity = $validated['quantity'];
        unset($validated['quantity']);
        $cost = $validated['cost'];
        unset($validated['cost']);
        $price = $validated['price'];
        unset($validated['price']);

        // Check if the products, quantity, cost and price are of the same length
        if (count($products) != count($quantity) || count($products) != count($cost) || count($products) != count($price)) {
            return response()->json(['error' => 'The products, quantity, cost and price must be of the same length'], 400);
        }

        if (isset($validated['payment_mode'])) {
            $payment_mode = $validated['payment_mode'];
            unset($validated['payment_mode']);
            $payment_date = $validated['payment_date'];
            unset($validated['payment_date']);
            $payment_amount = $validated['payment_amount'];
            unset($validated['payment_amount']);

            // Check if the payment_mode, payment_date and payment_amount are of the same length
            if (count($payment_mode) != count($payment_date) || count($payment_mode) != count($payment_amount)) {
                return response()->json(['error' => 'The payment mode, payment date and payment amount must be of the same length'], 400);
            }
        }

        try {
            DB::beginTransaction();

            $validated['user_id'] = auth()->user()->id;
            $validated['total'] = array_sum($price);
            $validated['revenue'] = array_sum($price) - array_sum($cost);
            if (isset($payment_amount) && array_sum($price) == array_sum($payment_amount)) {
                $validated['status'] = 'paid';
            } else {
                $validated['status'] = 'pending';
            }
            // Store the refund in the database
            $refund = Refund::create($validated);

            // Store refund products
            foreach ($products as $key => $product) {
                $product = [
                    'type' => 'refund',
                    'ref_id' => $refund->id,
                    'catalogue_id' => $product,
                    'quantity' => $quantity[$key],
                    'cost' => $cost[$key],
                    'price' => $price[$key],
                    'revenue' => $price[$key] - $cost[$key]
                ];
                Product::create($product);
            }

            if (isset($payment_mode)) {
                // Store refund payments
                foreach ($payment_mode as $key => $mode) {
                    $payment = [
                        'type' => 'refund',
                        'ref_id' => $refund->id,
                        'mode' => $mode,
                        'date' => $payment_date[$key],
                        'amount' => $payment_amount[$key]
                    ];
                    Payment::create($payment);
                }
            }

            // Store refund attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach ($files as $file) {
                    $attachment['type'] = 'refund';
                    $attachment['ref_id'] = $refund->id;
                    $attachment['name'] = $file->getClientOriginalName();
                    $attachment['extension'] = $file->getClientOriginalExtension();
                    $attachment['mime_type'] = $file->getClientMimeType();
                    $attachment['size'] = $file->getSize();
                    $attachment['url'] = $file->store('refunds', 'public');
                    Attachment::create($attachment);
                }
            }
            DB::commit();

            // Return the refund
            return response()->json([
                'refund' => $refund,
                'message' => 'Refund - ' . $refund->refund_id . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function show(Refund $refund)
    {
        $this->authorize('view', $refund, Refund::class);
        // return the view for showing the refund
        $refund_products = Product::where('type', 'refund')->where('ref_id', $refund->id)->get();
        $refund_payments = Payment::where('type', 'refund')->where('ref_id', $refund->id)->get();
        $refund_attachments = Attachment::where('type', 'refund')->where('ref_id', $refund->id)->get();
        return view('refund.show')->with(['refund' => $refund, 'refund_products' => $refund_products, 'refund_payments' => $refund_payments, 'refund_attachments' => $refund_attachments]);
    }


    public function showPdf(Request $request, $id)
    {
        $refund = Refund::where('id', $id)->first();
        $this->authorize('view', $refund, Refund::class);
        // return the view for showing the refund
        $refund_products = Product::where('type', 'refund')->where('ref_id', $refund->id)->get();
        $refund_payments = Payment::where('type', 'refund')->where('ref_id', $refund->id)->get();
        $pdf = Pdf::loadView('pdf.refund', ['refund' => $refund, 'refund_products' => $refund_products, 'refund_payments' => $refund_payments, 'view' => false]);
        return $pdf->download('refund.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function edit(Refund $refund)
    {
        $this->authorize('view', $refund, Refund::class);
        // return the view for editing the refund
        $companies = Company::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        $products = Catalogue::select('id', 'name')->where('status', 'active')->get();
        $refund_products = Product::where('type', 'refund')->where('ref_id', $refund->id)->get();
        $refund_payments = Payment::where('type', 'refund')->where('ref_id', $refund->id)->get();
        $refund_attachments = Attachment::where('type', 'refund')->where('ref_id', $refund->id)->get();
        return view('refund.create')->with(
            [
                'companies' => $companies,
                'customers' => $customers,
                'products' => $products,
                'refund' => $refund,
                'refund_products' => $refund_products,
                'refund_payments' => $refund_payments,
                'refund_attachments' => $refund_attachments
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRefundRequest  $request
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRefundRequest $request, Refund $refund)
    {

        $this->authorize('update', $refund, Refund::class);
        // Get the validated data from the request
        $validated = $request->validated();

        $products = $validated['product'];
        unset($validated['product']);
        $quantity = $validated['quantity'];
        unset($validated['quantity']);
        $cost = $validated['cost'];
        unset($validated['cost']);
        $price = $validated['price'];
        unset($validated['price']);

        // Check if the products, quantity, cost and price are of the same length
        if (count($products) != count($quantity) || count($products) != count($cost) || count($products) != count($price)) {
            return response()->json(['error' => 'The products, quantity, cost and price must be of the same length'], 400);
        }

        if (isset($validated['payment_mode'])) {
            $payment_mode = $validated['payment_mode'];
            unset($validated['payment_mode']);
            $payment_date = $validated['payment_date'];
            unset($validated['payment_date']);
            $payment_amount = $validated['payment_amount'];
            unset($validated['payment_amount']);

            // Check if the payment_mode, payment_date and payment_amount are of the same length
            if (count($payment_mode) != count($payment_date) || count($payment_mode) != count($payment_amount)) {
                return response()->json(['error' => 'The payment mode, payment date and payment amount must be of the same length'], 400);
            }
        }

        try {
            DB::beginTransaction();

            $validated['total'] = array_sum($price);
            $validated['revenue'] = array_sum($price) - array_sum($cost);
            if (isset($payment_amount) && array_sum($price) == array_sum($payment_amount)) {
                $validated['status'] = 'paid';
            } else {
                $validated['status'] = 'pending';
            }
            // Update the refund in the database
            $refund->update($validated);

            // Update refund products
            Product::where('type', 'refund')->where('ref_id', $refund->id)->delete();
            foreach ($products as $key => $product) {
                $product = [
                    'type' => 'refund',
                    'ref_id' => $refund->id,
                    'catalogue_id' => $product,
                    'quantity' => $quantity[$key],
                    'cost' => $cost[$key],
                    'price' => $price[$key],
                    'revenue' => $price[$key] - $cost[$key]
                ];
                Product::create($product);
            }

            // Update refund payments
            Payment::where('type', 'refund')->where('ref_id', $refund->id)->delete();

            if (isset($payment_mode)) {
                foreach ($payment_mode as $key => $mode) {
                    $payment = [
                        'type' => 'refund',
                        'ref_id' => $refund->id,
                        'mode' => $mode,
                        'date' => $payment_date[$key],
                        'amount' => $payment_amount[$key]
                    ];
                    Payment::create($payment);
                }
            }

            $existing_files = Attachment::where('type', 'refund')->where('ref_id', $refund->id)->get();

            // Store refund attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                // check file by name. if file exists, do not reupload and create an attachment, if the file is not in the request but in db delete the file and attachment
                foreach ($files as $file) {
                    $existing_file = $existing_files->where('name', $file->getClientOriginalName())->first();
                    if (!$existing_file) {
                        $attachment['type'] = 'refund';
                        $attachment['ref_id'] = $refund->id;
                        $attachment['name'] = $file->getClientOriginalName();
                        $attachment['extension'] = $file->getClientOriginalExtension();
                        $attachment['mime_type'] = $file->getClientMimeType();
                        $attachment['size'] = $file->getSize();
                        $attachment['url'] = $file->store('refunds', 'public');
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



            // Return the refund
            return response()->json([
                'refund' => $refund,
                'message' => 'Refund - ' . $refund->refund_id . ' updated successfully!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Refund $refund)
    {
        $this->authorize('delete', $refund, Refund::class);
        try {
            DB::beginTransaction();

            // Delete the refund products
            Product::where('type', 'refund')->where('ref_id', $refund->id)->delete();
            // Delete the refund payments
            Payment::where('type', 'refund')->where('ref_id', $refund->id)->delete();
            // Delete the refund attachments
            $attachments = Attachment::where('type', 'refund')->where('ref_id', $refund->id)->get();
            foreach ($attachments as $attachment) {
                Storage::disk('public')->delete($attachment->url);
                $attachment->delete();
            }
            // Delete the refund
            $refund->delete();
            DB::commit();
            return response()->json(['message' => 'Refund - ' . $refund->refund_id . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the refunds to excel
    public function export($type = 'excel')
    {
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new RefundsExport, 'refunds_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new RefundsExport, 'refunds_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new RefundsExport, 'refunds_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}