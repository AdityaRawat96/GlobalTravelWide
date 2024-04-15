<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Refund;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get this month's total revnue, total for invoice and refunds
        $invoicesRevenue = Invoice::where('invoice_date', '>=', Carbon::now()->startOfMonth());
        if (Auth::user()->role == 'staff') {
            $invoicesRevenue = $invoicesRevenue->where('user_id', Auth::id());
        }
        $invoicesRevenue = $invoicesRevenue->sum('revenue');

        $refundsRevenue = Refund::where('refund_date', '>=', Carbon::now()->startOfMonth());
        if (Auth::user()->role == 'staff') {
            $refundsRevenue = $refundsRevenue->where('user_id', Auth::id());
        }
        $refundsRevenue = $refundsRevenue->sum('total');

        // Calculate total commission for this month. If invoices have a affiliate_id, then it's commissionable. 
        // Get commission value from affiliate table which is the percent to be deducted from the invoice revenue 
        $commission = Invoice::where('invoice_date', '>=', Carbon::now()->startOfMonth())
            ->whereNotNull('affiliate_id');
        if (Auth::user()->role == 'staff') {
            $commission = $commission->where('user_id', Auth::id());
        }
        $commission = $commission
            ->sum(DB::raw('(revenue / 100) * (SELECT commission FROM affiliates WHERE id = affiliate_id)'));

        $totalRevenue = $invoicesRevenue + $refundsRevenue;

        $REVENUE_DATA = [
            $invoicesRevenue,
            $refundsRevenue,
            $commission,
        ];

        // Get past 6 months revenue data
        $pastInvoiceData = Invoice::select(DB::raw('DATE_FORMAT(invoice_date, "%Y-%m") as date'), DB::raw('SUM(total) as total'))
            ->where('invoice_date', '>=', Carbon::now()->subMonths(6));
        if (Auth::user()->role == 'staff') {
            $pastInvoiceData = $pastInvoiceData->where('user_id', Auth::id());
        }
        $pastInvoiceData = $pastInvoiceData
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $pastRefundData = Refund::select(DB::raw('DATE_FORMAT(refund_date, "%Y-%m") as date'), DB::raw('SUM(total) as total'))
            ->where('refund_date', '>=', Carbon::now()->subMonths(6));
        if (Auth::user()->role == 'staff') {
            $pastRefundData = $pastRefundData->where('user_id', Auth::id());
        }
        $pastRefundData = $pastRefundData
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Merge invoice and refund data and show month names

        $SALES_DATA = [];
        foreach ($pastInvoiceData as $invoice) {
            $SALES_DATA[] = [
                'month' => Carbon::parse($invoice->date)->format('F') . ' ' . Carbon::parse($invoice->date)->format('Y'),
                'amount' => $invoice->total,
            ];
        }

        foreach ($pastRefundData as $refund) {
            $month = Carbon::parse($refund->date)->format('F') . ' ' . Carbon::parse($refund->date)->format('Y');
            $key = array_search($month, array_column($SALES_DATA, 'month'));

            if ($key !== false) {
                $SALES_DATA[$key]['amount'] += $refund->total;
            } else {
                $SALES_DATA[] = [
                    'month' => $month,
                    'amount' => $refund->total,
                ];
            }
        }

        // Sort the data by month names
        usort($SALES_DATA, [$this, 'sortByMonth']);


        // Get last 2 weeks daily invoice data including days with 0 total
        $startDate = now()->subWeeks(2)->startOfDay(); // Start date of the last 2 weeks
        $endDate = now()->endOfDay(); // End date (today)

        // Generate an array of dates for the last 2 weeks
        $dateRange = [];
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->copy();
            $currentDate->addDay();
        }

        // Fetch invoices data
        $invoices = Invoice::select(
            DB::raw('DATE_FORMAT(invoice_date, "%b %d") as date'),
            DB::raw('COALESCE(COUNT(*), 0) as total')
        )
            ->whereBetween('invoice_date', [$startDate, $endDate]);
        if (Auth::user()->role == 'staff') {
            $invoices = $invoices->where('user_id', Auth::id());
        }
        $invoices = $invoices
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Map fetched data to the desired format including missing dates
        $invoiceData = [];
        foreach ($dateRange as $date) {
            $formattedDate = $date->format('M d');
            $total = 0;
            // Find total for the date if it exists in the fetched data
            foreach ($invoices as $invoice) {
                if ($invoice->date === $formattedDate) {
                    $total = $invoice->total;
                    break;
                }
            }
            // Add data to the result array
            $invoiceData[] = ['date' => $formattedDate, 'total' => $total];
        }

        // split the data into 2 arrays for the last 2 weeks
        $invoicesTotal = array_map(function ($data) {
            return $data['total'];
        }, $invoiceData);

        $invoicesDate = array_map(function ($data) {
            return $data['date'];
        }, $invoiceData);

        $invoiceTotalSum = 0;
        $invoiceMaxTotal = 0;
        foreach ($invoiceData as $data) {
            $invoiceTotalSum += $data['total'];
            if ($data['total'] > $invoiceMaxTotal) {
                $invoiceMaxTotal = $data['total'];
            }
        }

        $INVOICE_DATA = [
            'invoicesTotal' => $invoicesTotal,
            'invoicesDate' => $invoicesDate,
            'invoiceTotalSum' => $invoiceTotalSum,
            'invoiceMaxTotal' => $invoiceMaxTotal,
        ];

        return view('dashboard.index')->with([
            'totalRevenue' => $totalRevenue,
            'REVENUE_DATA' => $REVENUE_DATA,
            'SALES_DATA' => $SALES_DATA,
            'INVOICE_DATA' => $INVOICE_DATA,
        ]);
    }

    // Custom sorting function to sort by month name
    function sortByMonth($a, $b)
    {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        return array_search($a['month'], $months) - array_search($b['month'], $months);
    }
}
