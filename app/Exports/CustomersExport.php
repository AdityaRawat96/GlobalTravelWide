<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomersExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $app_short_name = env('APP_SHORT', 'TW');
        // Append short name to the customer id

        $customers = Customer::select(
            DB::raw("CONCAT('C', LPAD(id, 5, '0')) as customer_id"),
            'name',
            'email',
            'phone',
            DB::raw("CONCAT('" . $app_short_name . "', LPAD(added_by, 5, '0')) as added_by"),
        )->get();

        return $customers;
    }

    public function headings(): array
    {
        return [
            'Customer ID',
            'Name',
            'Email',
            'Phone',
            'Added By',
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