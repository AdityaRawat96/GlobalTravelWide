<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Affiliate;
use App\Models\Attachment;
use App\Models\Carrier;
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

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Invoice::class);
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
            $query = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
                ->leftJoin('carriers', 'invoices.carrier_id', '=', 'carriers.id')
                ->select(
                    'invoices.id',
                    'invoices.invoice_id',
                    'invoices.status as status',
                    'invoices.ref_number',
                    DB::raw("CONCAT('" . env('APP_SHORT', 'TW') . "', LPAD(invoices.user_id, 5, '0')) as user_id"),
                    DB::raw("CONCAT('C', LPAD(invoices.customer_id, 5, '0')) as customer_id"),
                    'customers.name as customer_name',
                    'carriers.name as carrier_name',
                    DB::raw("DATE_FORMAT(invoices.departure_date, '%d-%m-%Y') as departure_date"),
                    DB::raw("DATE_FORMAT(invoices.invoice_date, '%d-%m-%Y') as invoice_date"),
                    'invoices.due_date',
                    'invoices.total',
                );

            // Check if the user is not an admin
            // if (auth()->user()->role != 'admin') {
            //     $query->where('invoices.user_id', auth()->user()->id);
            // }


            // only if the filter is not empty and exists filter the records
            if (!empty($request->filter) && isset($request->filter)) {
                $main_date_filter = false;
                foreach ($request->filter as $filter) {
                    if ($filter['type'] == 'text') {
                        $query->where($filter['name'], $filter['comparator'], $filter['value']);
                    } else if ($filter['type'] == 'date') {
                        // Check if $filter['name'] includes '_main'
                        if (strpos($filter['name'], '_main') !== false) {
                            $main_date_filter = true;
                            $query->whereDate(str_replace('_main', '', $filter['name']), $filter['comparator'], $filter['value']);
                        }
                        // if (!$main_date_filter) {
                        //     $query->whereDate($filter['name'], $filter['comparator'], $filter['value']);
                        // }
                    }
                }
            }

            // Add the search query trim the search value and check if it is not empty
            if (!empty($search['value'])) {
                $query->where(function ($query) use ($columns, $search) {
                    $query->whereRaw("REPLACE(customers.name, ' ', '') LIKE '%" . str_replace(' ', '', $search['value']) . "%'")
                        ->orWhereRaw("REPLACE(carriers.name, ' ', '') LIKE '%" . str_replace(' ', '', $search['value']) . "%'"); // Add carrier name search
                    foreach ($columns as $column) {
                        if ($column['searchable'] == 'true' && $column['data'] != 'customer_name' && $column['data'] != 'carrier_name') {
                            $query->orWhereRaw("REPLACE(invoices." . $column['data'] . ", ' ', '') LIKE '%" . str_replace(' ', '', $search['value']) . "%'");
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
            } else {
                // Order by first status and then by due date
                $query->orderBy('status', 'desc')->orderBy('due_date', 'asc');
            }

            // get count of the records from query
            $recordsFiltered = $query->count();

            // Get the data
            $query->offset($start)
                ->limit($length);

            $data_filtered = $query->get();

            $datatable = DataTables::of($data_filtered)
                ->setOffset($start)
                ->with('recordsTotal', Invoice::count())
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
        return view('invoice.index')->with(['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Invoice::class);
        // return the view for creating a new invoice
        $companies = Company::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        $affiliates = Affiliate::select('id', 'name')->get();
        $products = Catalogue::select('id', 'name')->where('status', 'active')->get();
        $carriers = Carrier::select('id', 'name')->get();
        return view('invoice.create')->with(['companies' => $companies, 'customers' => $customers, 'products' => $products, 'affiliates' => $affiliates, 'carriers' => $carriers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        $this->authorize('create', Invoice::class);
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
        $cost_alt = $validated['cost_alt'];
        unset($validated['cost_alt']);
        $price_alt = $validated['price_alt'];
        unset($validated['price_alt']);

        // Check if the products, quantity, cost and price are of the same length
        if (count($products) != count($quantity) || count($products) != count($cost) || count($products) != count($price) || count($products) != count($cost_alt) || count($products) != count($price_alt)) {
            return response()->json(['error' => 'The products, quantity, cost and price must be of the same length'], 400);
        }

        if (isset($validated['payment_mode'])) {
            $payment_mode = $validated['payment_mode'];
            unset($validated['payment_mode']);
            $payment_date = $validated['payment_date'];
            unset($validated['payment_date']);
            $payment_amount = $validated['payment_amount'];
            unset($validated['payment_amount']);
            $payment_amount_alt = $validated['payment_amount_alt'];
            unset($validated['payment_amount_alt']);

            // Check if the payment_mode, payment_date and payment_amount are of the same length
            if (count($payment_mode) != count($payment_date) || count($payment_mode) != count($payment_amount) || count($payment_mode) != count($payment_amount_alt)) {
                return response()->json(['error' => 'The payment mode, payment date and payment amount must be of the same length'], 400);
            }
        }

        try {
            DB::beginTransaction();

            $validated['user_id'] = auth()->user()->id;
            $validated['total'] = array_sum($price);
            $validated['revenue'] = array_sum($price) - array_sum($cost);

            if (isset($payment_amount)) {
                $price_sum = array_sum($price);
                $payment_sum = array_sum($payment_amount);
                $price_sum = number_format($price_sum, 2, '.', '');
                $payment_sum = number_format($payment_sum, 2, '.', '');
                if ($price_sum == $payment_sum) {
                    $validated['status'] = 'paid';
                } else {
                    $validated['status'] = 'pending';
                }
            } else {
                $validated['status'] = 'pending';
            }

            // Store the invoice in the database
            $invoice = Invoice::create($validated);

            // Store invoice products
            foreach ($products as $key => $product) {
                $product = [
                    'type' => 'invoice',
                    'ref_id' => $invoice->id,
                    'catalogue_id' => $product,
                    'quantity' => $quantity[$key],
                    'cost' => $cost[$key],
                    'price' => $price[$key],
                    'revenue' => $price[$key] - $cost[$key]
                ];
                Product::create($product);
            }

            // Store invoice alternate products
            if ($invoice->currency == 'pkr') {
                foreach ($products as $key => $product) {
                    $product = [
                        'type' => 'invoice',
                        'ref_id' => $invoice->id,
                        'catalogue_id' => $product,
                        'quantity' => $quantity[$key],
                        'cost' => $cost_alt[$key],
                        'price' => $price_alt[$key],
                        'revenue' => $price_alt[$key] - $cost_alt[$key],
                        'currency' => 'pkr'
                    ];
                    Product::create($product);
                }
            }

            if (isset($payment_mode)) {
                // Store invoice payments
                foreach ($payment_mode as $key => $mode) {
                    $payment = [
                        'type' => 'invoice',
                        'ref_id' => $invoice->id,
                        'mode' => $mode,
                        'date' => $payment_date[$key],
                        'amount' => $payment_amount[$key]
                    ];
                    Payment::create($payment);
                }

                // Store invoice alternate payments
                if ($invoice->currency == 'pkr') {
                    foreach ($payment_amount_alt as $key => $amount) {
                        $payment = [
                            'type' => 'invoice',
                            'ref_id' => $invoice->id,
                            'mode' => $payment_mode[$key],
                            'date' => $payment_date[$key],
                            'amount' => $amount,
                            'currency' => 'pkr'
                        ];
                        Payment::create($payment);
                    }
                }
            }

            // Store invoice attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach ($files as $file) {
                    $attachment['type'] = 'invoice';
                    $attachment['ref_id'] = $invoice->id;
                    $attachment['name'] = $file->getClientOriginalName();
                    $attachment['extension'] = $file->getClientOriginalExtension();
                    $attachment['mime_type'] = $file->getClientMimeType();
                    $attachment['size'] = $file->getSize();
                    $attachment['url'] = $file->store('invoices', 'public');
                    Attachment::create($attachment);
                }
            }
            DB::commit();

            // Return the invoice
            return response()->json([
                'invoice' => $invoice,
                'message' => 'Invoice - ' . $invoice->invoice_id . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Invoice $invoice)
    {
        $this->authorize('view', $invoice, Invoice::class);
        if ($request->currency == 'pkr') {
            $invoice_products = Product::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'pkr')->get();
            $invoice_payments = Payment::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'pkr')->get();
            $invoice->total = $invoice_products->sum('price');
            $invoice->revenue = $invoice_products->sum('price') - $invoice_products->sum('cost');
            $invoice->currencySymbol = '₨';
            $invoice->type = "Customer Invoice";
        } else {
            $invoice_products = Product::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'gbp')->get();
            $invoice_payments = Payment::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'gbp')->get();
            $invoice->currencySymbol = '£';
            $invoice->type = "Office Invoice";
        }
        $invoice_attachments = Attachment::where('type', 'invoice')->where('ref_id', $invoice->id)->get();
        // return the view for showing the invoice
        return view('invoice.show')->with(['invoice' => $invoice, 'invoice_products' => $invoice_products, 'invoice_payments' => $invoice_payments, 'invoice_attachments' => $invoice_attachments]);
    }


    public function showPdf(Request $request, $id)
    {
        $invoice = Invoice::where('id', $id)->first();
        $this->authorize('view', $invoice, Invoice::class);
        if ($request->currency == 'pkr') {
            $invoice_products = Product::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'pkr')->get();
            $invoice_payments = Payment::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'pkr')->get();
            $invoice->total = $invoice_products->sum('price');
            $invoice->revenue = $invoice_products->sum('price') - $invoice_products->sum('cost');
            $invoice->currencySymbol = '₨';
            $invoice->type = "Customer Invoice";
        } else {
            $invoice_products = Product::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'gbp')->get();
            $invoice_payments = Payment::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'gbp')->get();
            $invoice->currencySymbol = '£';
            $invoice->type = "Office Invoice";
        }
        // return the view for showing the invoice
        $pdf = Pdf::loadView('pdf.invoice', ['invoice' => $invoice, 'invoice_products' => $invoice_products, 'invoice_payments' => $invoice_payments, 'view' => false]);
        return $pdf->download($invoice->invoice_id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $this->authorize('view', $invoice, Invoice::class);
        // return the view for editing the invoice
        $companies = Company::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        $affiliates = Affiliate::select('id', 'name')->get();
        $products = Catalogue::select('id', 'name')->where('status', 'active')->get();
        $carriers = Carrier::select('id', 'name')->get();
        $invoice_products = Product::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'gbp')->get();
        $invoice_payments = Payment::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'gbp')->get();
        $invoice_attachments = Attachment::where('type', 'invoice')->where('ref_id', $invoice->id)->get();

        if ($invoice->currency == 'pkr') {
            $invoice_products_alt = Product::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'pkr')->get();
            $invoice_payments_alt = Payment::where('type', 'invoice')->where('ref_id', $invoice->id)->where('currency', 'pkr')->get();

            foreach ($invoice_products as $key => $product) {
                $invoice_products[$key]->cost_alt = $invoice_products_alt[$key]->cost;
                $invoice_products[$key]->price_alt = $invoice_products_alt[$key]->price;
            }

            foreach ($invoice_payments as $key => $payment) {
                $invoice_payments[$key]->amount_alt = $invoice_payments_alt[$key]->amount;
            }
        }

        return view('invoice.create')->with(
            [
                'companies' => $companies,
                'customers' => $customers,
                'products' => $products,
                'affiliates' => $affiliates,
                'carriers' => $carriers,
                'invoice' => $invoice,
                'invoice_products' => $invoice_products,
                'invoice_payments' => $invoice_payments,
                'invoice_attachments' => $invoice_attachments
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {

        $this->authorize('update', $invoice, Invoice::class);
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
        if ($validated['currency'] == 'pkr') {
            $cost_alt = $validated['cost_alt'];
            unset($validated['cost_alt']);
            $price_alt = $validated['price_alt'];
            unset($validated['price_alt']);
        }

        // Check if the products, quantity, cost and price are of the same length
        if (count($products) != count($quantity) || count($products) != count($cost) || count($products) != count($price)) {
            return response()->json(['error' => 'The products, quantity, cost and price must be of the same length'], 400);
        }
        if ($validated['currency'] == 'pkr') {
            if (count($products) != count($cost_alt) || count($products) != count($price_alt)) {
                return response()->json(['error' => 'The products, quantity, cost and price must be of the same length'], 400);
            }
        }

        if (isset($validated['payment_mode'])) {
            $payment_mode = $validated['payment_mode'];
            unset($validated['payment_mode']);
            $payment_date = $validated['payment_date'];
            unset($validated['payment_date']);
            $payment_amount = $validated['payment_amount'];
            unset($validated['payment_amount']);
            if ($validated['currency'] == 'pkr') {
                $payment_amount_alt = $validated['payment_amount_alt'];
                unset($validated['payment_amount_alt']);
            }
            // Check if the payment_mode, payment_date and payment_amount are of the same length
            if (count($payment_mode) != count($payment_date) || count($payment_mode) != count($payment_amount)) {
                return response()->json(['error' => 'The payment mode, payment date and payment amount must be of the same length'], 400);
            }
            if ($validated['currency'] == 'pkr') {
                // Check if the payment_mode, payment_date and payment_amount are of the same length
                if (count($payment_mode) != count($payment_amount_alt)) {
                    return response()->json(['error' => 'The payment mode, payment date and payment amount must be of the same length'], 400);
                }
            }
        }

        try {
            DB::beginTransaction();

            $validated['total'] = array_sum($price);
            $validated['revenue'] = array_sum($price) - array_sum($cost);
            if (isset($payment_amount)) {
                $price_sum = array_sum($price);
                $payment_sum = array_sum($payment_amount);
                $price_sum = number_format($price_sum, 2, '.', '');
                $payment_sum = number_format($payment_sum, 2, '.', '');
                if ($price_sum == $payment_sum) {
                    $validated['status'] = 'paid';
                } else {
                    $validated['status'] = 'pending';
                }
            } else {
                $validated['status'] = 'pending';
            }
            // Update the invoice in the database
            $invoice->update($validated);

            // Update invoice products
            Product::where('type', 'invoice')->where('ref_id', $invoice->id)->delete();
            foreach ($products as $key => $product) {
                $product = [
                    'type' => 'invoice',
                    'ref_id' => $invoice->id,
                    'catalogue_id' => $product,
                    'quantity' => $quantity[$key],
                    'cost' => $cost[$key],
                    'price' => $price[$key],
                    'revenue' => $price[$key] - $cost[$key]
                ];
                Product::create($product);
            }

            // Store invoice alternate products
            if ($invoice->currency == 'pkr') {
                foreach ($products as $key => $product) {
                    $product = [
                        'type' => 'invoice',
                        'ref_id' => $invoice->id,
                        'catalogue_id' => $product,
                        'quantity' => $quantity[$key],
                        'cost' => $cost_alt[$key],
                        'price' => $price_alt[$key],
                        'revenue' => $price_alt[$key] - $cost_alt[$key],
                        'currency' => 'pkr'
                    ];
                    Product::create($product);
                }
            }

            // Update invoice payments
            Payment::where('type', 'invoice')->where('ref_id', $invoice->id)->delete();

            if (isset($payment_mode)) {
                foreach ($payment_mode as $key => $mode) {
                    $payment = [
                        'type' => 'invoice',
                        'ref_id' => $invoice->id,
                        'mode' => $mode,
                        'date' => $payment_date[$key],
                        'amount' => $payment_amount[$key]
                    ];
                    Payment::create($payment);
                }

                // Store invoice alternate payments
                if ($invoice->currency == 'pkr') {
                    foreach ($payment_amount_alt as $key => $amount) {
                        $payment = [
                            'type' => 'invoice',
                            'ref_id' => $invoice->id,
                            'mode' => $payment_mode[$key],
                            'date' => $payment_date[$key],
                            'amount' => $amount,
                            'currency' => 'pkr'
                        ];
                        Payment::create($payment);
                    }
                }
            }

            $existing_files = Attachment::where('type', 'invoice')->where('ref_id', $invoice->id)->get();

            // Store invoice attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                // check file by name. if file exists, do not reupload and create an attachment, if the file is not in the request but in db delete the file and attachment
                foreach ($files as $file) {
                    $existing_file = $existing_files->where('name', $file->getClientOriginalName())->first();
                    if (!$existing_file) {
                        $attachment['type'] = 'invoice';
                        $attachment['ref_id'] = $invoice->id;
                        $attachment['name'] = $file->getClientOriginalName();
                        $attachment['extension'] = $file->getClientOriginalExtension();
                        $attachment['mime_type'] = $file->getClientMimeType();
                        $attachment['size'] = $file->getSize();
                        $attachment['url'] = $file->store('invoices', 'public');
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



            // Return the invoice
            return response()->json([
                'invoice' => $invoice,
                'message' => 'Invoice - ' . $invoice->invoice_id . ' updated successfully!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorize('delete', $invoice, Invoice::class);
        try {
            DB::beginTransaction();

            // Delete the invoice products
            Product::where('type', 'invoice')->where('ref_id', $invoice->id)->delete();
            // Delete the invoice payments
            Payment::where('type', 'invoice')->where('ref_id', $invoice->id)->delete();
            // Delete the invoice attachments
            $attachments = Attachment::where('type', 'invoice')->where('ref_id', $invoice->id)->get();
            foreach ($attachments as $attachment) {
                Storage::disk('public')->delete($attachment->url);
                $attachment->delete();
            }
            // Delete the invoice
            $invoice->delete();
            DB::commit();
            return response()->json(['message' => 'Invoice - ' . $invoice->invoice_id . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the invoices to excel
    public function export($type = 'excel')
    {
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new InvoicesExport, 'invoices_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new InvoicesExport, 'invoices_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new InvoicesExport, 'invoices_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}
