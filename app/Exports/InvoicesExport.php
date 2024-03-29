<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoicesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
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
                DB::raw("CONCAT(UCASE(LEFT(invoices.status, 1)), SUBSTRING(invoices.status, 2)) as status"),
                'invoices.invoice_id',
                'invoices.ref_number',
                DB::raw("CONCAT('" . $app_short_name . "', LPAD(invoices.user_id, 5, '0')) as user_id"),
                DB::raw("CONCAT('C', LPAD(invoices.customer_id, 5, '0')) as customer_id"),
                'customers.name as customer_name',
                DB::raw("DATE_FORMAT(invoices.departure_date, '%d-%m-%Y') as departure_date"),
                DB::raw("DATE_FORMAT(invoices.invoice_date, '%d-%m-%Y') as invoice_date"),
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

    public function styles(Worksheet $sheet)
    {
        $sheet->getParent()->getDefaultStyle()->getAlignment()->setHorizontal('left');
        $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical('center');

        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '2d4154']]],
        ];
    }
}