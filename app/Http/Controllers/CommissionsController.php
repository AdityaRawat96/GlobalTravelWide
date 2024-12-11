<?php

namespace App\Http\Controllers;

use App\Exports\DetailedCommissionsExport;
use App\Exports\CommissionsExport;
use App\Models\Invoice;
use App\Models\Refund;
use App\Models\User;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CommissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', Auth::user());

        if ($request->ajax()) {
            // Get the values from the request object
            $start = $request->start;
            $length = $request->length;
            $search = $request->search;
            $order = $request->order;
            $columns = $request->columns;

            // Build an eloquent query using these values
            $query =  Affiliate::select(
                'id',
                'name',
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

            foreach ($data_filtered as $index => $affiliate) {
                // only if the filter is not empty and exists filter the records
                $commission_calculation = $request->filter['commission_calculation'];
                $invoice_cal = $commission_calculation;
                $start_date = $request->filter['start_date'];
                $end_date = $request->filter['end_date'];

                $invoices_sum_total = Invoice::where('affiliate_id', $affiliate->id)->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->sum('total');
                $invoices_sum_revenue = Invoice::where('affiliate_id', $affiliate->id)->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->sum('revenue');
                $invoices_sum_commission = Invoice::where('affiliate_id', $affiliate->id)->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->sum('commission');

                $total = $invoices_sum_total;
                $commission_generated = $invoices_sum_commission;
                $revenue = ($invoices_sum_total - $commission_generated);
                $total_revenue += $revenue;

                $data_filtered[$index]->total = $total;
                $data_filtered[$index]->revenue = $revenue;
                $data_filtered[$index]->commission_percentage = $commission_generated ? number_format(($commission_generated / $total) * 100, 2) : 0;
                $data_filtered[$index]->commission = $commission_generated;
            }

            $datatable = DataTables::of($data_filtered)
                ->setOffset($start)
                ->with('revenueTotal', $total_revenue)
                ->with('recordsTotal', Affiliate::count())
                ->with('sqlQuery', $query->toSql()) // Note: It's better to use ->toSql() to get the SQL query for debugging purposes
                ->with('recordsFiltered', $recordsFiltered)
                ->addColumn('id', function ($data) {
                    return env('APP_SHORT') . str_pad($data->id, 5, '0', STR_PAD_LEFT);
                })
                ->make(true);
            return $datatable;
        }
        return view('commission.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commissions  $commissions
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $affiliate = Affiliate::find($id);
        // $this->authorize('view', Auth::user(), $affiliate);

        if ($request->ajax()) {
            if ($affiliate == null) {
                // return empty datatable if affiliate is not found
                return DataTables::of([])->make(true);
            }

            $commission_calculation = $request->filter['commission_calculation'];
            $invoice_cal = $commission_calculation;
            $refund_cal = $commission_calculation == 'invoice_date' ? 'refund_date' : $commission_calculation;
            $start_date = $request->filter['start_date'];
            $end_date = $request->filter['end_date'];

            // show all the invoices geenreaed by this affiliate in a combined datatable

            $invoices = Invoice::where('affiliate_id', $affiliate->id)->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->get();

            $invoices_sum_total = $invoices->sum('total');
            $invoices_sum_revenue = $invoices->sum('revenue');
            $invoices_sum_commission = $invoices->sum('commission');

            $total = $invoices_sum_total;
            $revenue = ($invoices_sum_revenue - $invoices_sum_commission);
            $commission = $invoices_sum_commission;

            $data = $invoices;

            $datatable = DataTables::of($data)
                ->with('total', $total)
                ->with('revenue', $revenue)
                ->with('commission', $commission)
                ->addColumn('invoice_id', function ($data) {
                    return $data instanceof Invoice ? $data->invoice_id : $data->refund_id;
                })
                ->addColumn('customer_name', function ($data) {
                    return $data->customer->name;
                })
                ->addColumn('type', function ($data) {
                    return $data instanceof Invoice ? 'Invoice' : 'Refund';
                })
                ->addColumn('date', function ($data) {
                    return $data instanceof Invoice ? $data->invoice_date : $data->refund_date;
                })
                ->addColumn('commission_percentage', function ($data) {
                    return $data->commission ? number_format(($data->commission / $data->total) * 100, 2) : 0;
                })
                ->addColumn('total', function ($data) {
                    return $data->total;
                })
                ->addColumn('revenue', function ($data) {
                    return $data->revenue;
                })
                ->addColumn('commission', function ($data) {
                    return $data->commission;
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

        $commission_calculation = isset($request->commission_calculation) ? $request->commission_calculation : 'invoice_date';
        $start_date = isset($request->start_date) ? $request->start_date : null;
        $end_date = isset($request->end_date) ? $request->end_date : null;

        $data['affiliate_id'] = $id;
        $data['commission_calculation'] = $commission_calculation;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // return view with data
        return view('commission.show')->with('data', $data);
    }

    // Export the commissions to excel
    public function export(Request $request, $type = 'excel')
    {
        $data['affiliate_id'] = $request->affiliate_id;
        $data['commission_calculation'] = $request->commission_calculation;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new CommissionsExport($data), 'commissions_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new CommissionsExport($data), 'commissions_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new CommissionsExport($data), 'commissions_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }

    // Export the commissions to excel
    public function exportDetails(Request $request, $type = 'excel')
    {
        $data['affiliate_id'] = $request->affiliate_id;
        $data['commission_calculation'] = $request->commission_calculation;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new DetailedCommissionsExport($data), env("APP_SHORT") . str_pad($data['affiliate_id'], 5, '0', STR_PAD_LEFT) . '_commissions_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new DetailedCommissionsExport($data), env("APP_SHORT") . str_pad($data['affiliate_id'], 5, '0', STR_PAD_LEFT) . 'commissions_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new DetailedCommissionsExport($data), env("APP_SHORT") . str_pad($data['affiliate_id'], 5, '0', STR_PAD_LEFT) . 'commissions_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}