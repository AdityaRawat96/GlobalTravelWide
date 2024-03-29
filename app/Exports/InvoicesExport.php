<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $app_short_name = env('APP_SHORT', 'TW');
        // Append short name to the invoice id

        $invoices = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->select(
                'invoices.status',
                'invoices.invoice_id',
                'invoices.ref_number',
                DB::raw("CONCAT('" . $app_short_name . "', LPAD(invoices.user_id, 5, '0')) as user_id"),
                DB::raw("CONCAT('C', LPAD(invoices.customer_id, 5, '0')) as customer_id"),
                'customers.name as customer_name',
                'invoices.departure_date',
                'invoices.invoice_date',
                'invoices.total',
            )->get();

        return $invoices;
    }

    public function headings(): array
    {
        return [
            'Status',
            'Invoice ID',
            'Reference #',
            'Employee ID',
            'Customer ID',
            'Customer Name',
            'Departure Date',
            'Invoice Date',
            'Amount (£)',
        ];
    }
}
