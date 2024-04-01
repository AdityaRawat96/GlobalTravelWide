<?php

namespace App\Exports;

use App\Models\Quotation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuotationsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $app_short_name = env('APP_SHORT', 'TW');
        // Append short name to the quotation id

        $quotations = Quotation::join('customers', 'quotations.customer_id', '=', 'customers.id')
            ->select(
                'quotations.quotation_id',
                DB::raw("CONCAT('" . $app_short_name . "', LPAD(quotations.user_id, 5, '0')) as user_id"),
                DB::raw("CONCAT('C', LPAD(quotations.customer_id, 5, '0')) as customer_id"),
                'customers.name as customer_name',
                DB::raw("DATE_FORMAT(quotations.quotation_date, '%d-%m-%Y') as quotation_date"),
                'quotations.total',
            )->get();

        return $quotations;
    }

    public function headings(): array
    {
        return [
            'Quotation ID',
            'Employee ID',
            'Customer ID',
            'Customer Name',
            'Quotation Date',
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