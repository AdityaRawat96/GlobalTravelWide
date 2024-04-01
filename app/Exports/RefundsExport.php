<?php

namespace App\Exports;

use App\Models\Refund;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RefundsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $app_short_name = env('APP_SHORT', 'TW');
        // Append short name to the refund id

        $refunds = Refund::join('customers', 'refunds.customer_id', '=', 'customers.id')
            ->select(
                DB::raw("CONCAT(UCASE(LEFT(refunds.status, 1)), SUBSTRING(refunds.status, 2)) as status"),
                'refunds.refund_id',
                'refunds.ref_number',
                DB::raw("CONCAT('" . $app_short_name . "', LPAD(refunds.user_id, 5, '0')) as user_id"),
                DB::raw("CONCAT('C', LPAD(refunds.customer_id, 5, '0')) as customer_id"),
                'customers.name as customer_name',
                DB::raw("DATE_FORMAT(refunds.refund_date, '%d-%m-%Y') as refund_date"),
                'refunds.total',
            )->get();

        return $refunds;
    }

    public function headings(): array
    {
        return [
            'Status',
            'Refund ID',
            'Reference #',
            'Employee ID',
            'Customer ID',
            'Customer Name',
            'Refund Date',
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