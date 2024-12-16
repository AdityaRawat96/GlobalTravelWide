<?php

namespace App\Http\Controllers;

use App\Exports\DetailedSalesExport;
use App\Exports\SalesExport;
use App\Models\Invoice;
use App\Models\Refund;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        if ($request->ajax()) {
            // Get the values from the request object
            $start = $request->start;
            $length = $request->length;
            $search = $request->search;
            $order = $request->order;
            $columns = $request->columns;

            // Build an eloquent query using these values
            $query =  User::select(
                'id',
                'first_name',
                'last_name',
            );

            // Add the search query trim the search value and check if it is not empty
            if (!empty($search['value'])) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . trim($search['value']) . '%')
                        ->orWhere('last_name', 'like', '%' . trim($search['value']) . '%');
                });
            }

            // get count of the records from query
            $recordsFiltered = $query->count();

            // Get the data
            $query->offset($start)
                ->limit($length);

            $data_filtered = $query->get();

            $total_revenue = 0;

            foreach ($data_filtered as $index => $user) {
                // only if the filter is not empty and exists filter the records
                $sale_calculation = $request->filter['sale_calculation'];
                $invoice_cal = $sale_calculation;
                $refund_cal = $sale_calculation == 'invoice_date' ? 'refund_date' : $sale_calculation;
                $start_date = $request->filter['start_date'];
                $end_date = $request->filter['end_date'];

                $invoices_sum_total = Invoice::where('user_id', $user->id)->where('status', '=', 'paid')->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->sum('total');
                $invoices_sum_revenue = Invoice::where('user_id', $user->id)->where('status', '=', 'paid')->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->sum('revenue');
                $refunds_sum_total = Refund::where('user_id', $user->id)->where('status', '=', 'paid')->where($refund_cal, '>=', $start_date)->where($refund_cal, '<=', $end_date)->sum('total');
                $refunds_sum_revenue = Refund::where('user_id', $user->id)->where('status', '=', 'paid')->where($refund_cal, '>=', $start_date)->where($refund_cal, '<=', $end_date)->sum('revenue');

                $total = $invoices_sum_total + $refunds_sum_total;
                $revenue = $invoices_sum_revenue + $refunds_sum_revenue;
                $total_revenue += $revenue;
                $cost = $total - $revenue;

                $data_filtered[$index]->total = $total;
                $data_filtered[$index]->revenue = $revenue;
                $data_filtered[$index]->cost = $cost;
            }

            $datatable = DataTables::of($data_filtered)
                ->setOffset($start)
                ->with('revenueTotal', $total_revenue)
                ->with('recordsTotal', User::count())
                ->with('sqlQuery', $query->toSql()) // Note: It's better to use ->toSql() to get the SQL query for debugging purposes
                ->with('recordsFiltered', $recordsFiltered)
                ->addColumn('full_name', function ($data) {
                    return $data->first_name . ' ' . $data->last_name;
                })
                ->addColumn('id', function ($data) {
                    return env('APP_SHORT') . str_pad($data->id, 5, '0', STR_PAD_LEFT);
                })
                ->make(true);
            return $datatable;
        }
        return view('sale.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        $this->authorize('view', $user, User::class);

        if ($request->ajax()) {
            $sale_calculation = $request->filter['sale_calculation'];
            $invoice_cal = $sale_calculation;
            $refund_cal = $sale_calculation == 'invoice_date' ? 'refund_date' : $sale_calculation;
            $start_date = $request->filter['start_date'];
            $end_date = $request->filter['end_date'];

            // show all the invoices and refunds geenreaed by this user in a combined datatable

            $invoices = Invoice::where('user_id', $user->id)->where('status', '=', 'paid')->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->get();
            $refunds = Refund::where('user_id', $user->id)->where('status', '=', 'paid')->where($refund_cal, '>=', $start_date)->where($refund_cal, '<=', $end_date)->get();

            $invoices_sum_total = $invoices->sum('total');
            $invoices_sum_revenue = $invoices->sum('revenue');
            $refunds_sum_total = $refunds->sum('total');
            $refunds_sum_revenue = $refunds->sum('revenue');

            $total = $invoices_sum_total + $refunds_sum_total;
            $revenue = $invoices_sum_revenue + $refunds_sum_revenue;
            $cost = $total - $revenue;

            $data = $invoices->merge($refunds);

            $datatable = DataTables::of($data)
                ->with('total', $total)
                ->with('revenue', $revenue)
                ->with('cost', $cost)
                ->addColumn('invoice_id', function ($data) {
                    return $data instanceof Invoice ? $data->invoice_id : $data->refund_id;
                })
                ->addColumn('customer_name', function ($data) {
                    return isset($data->customer->name) ? $data->customer->name : '';
                })
                ->addColumn('type', function ($data) {
                    return $data instanceof Invoice ? 'Invoice' : 'Refund';
                })
                ->addColumn('date', function ($data) {
                    return $data instanceof Invoice ? $data->invoice_date : $data->refund_date;
                })
                ->addColumn('total', function ($data) {
                    return $data->total;
                })
                ->addColumn('revenue', function ($data) {
                    return $data->revenue;
                })
                ->addColumn('cost', function ($data) {
                    return $data->total - $data->revenue;
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

        $sale_calculation = isset($request->sale_calculation) ? $request->sale_calculation : 'invoice_date';
        $start_date = isset($request->start_date) ? $request->start_date : null;
        $end_date = isset($request->end_date) ? $request->end_date : null;

        $data['user_id'] = $user->id;
        $data['sale_calculation'] = $sale_calculation;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // return view with data
        return view('sale.show')->with('data', $data);
    }

    // Export the sales to excel
    public function export(Request $request, $type = 'excel')
    {
        $data['user_id'] = $request->user_id;
        $data['sale_calculation'] = $request->sale_calculation;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new SalesExport($data), 'sales_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new SalesExport($data), 'sales_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new SalesExport($data), 'sales_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }

    // Export the sales to excel
    public function exportDetails(Request $request, $type = 'excel')
    {
        $data['user_id'] = $request->user_id;
        $data['sale_calculation'] = $request->sale_calculation;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new DetailedSalesExport($data), env("APP_SHORT") . str_pad($data['user_id'], 5, '0', STR_PAD_LEFT) . '_sales_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new DetailedSalesExport($data), env("APP_SHORT") . str_pad($data['user_id'], 5, '0', STR_PAD_LEFT) . 'sales_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new DetailedSalesExport($data), env("APP_SHORT") . str_pad($data['user_id'], 5, '0', STR_PAD_LEFT) . 'sales_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}
