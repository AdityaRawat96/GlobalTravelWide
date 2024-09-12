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
        // Set default alignment
        $sheet->getParent()->getDefaultStyle()->getAlignment()->setHorizontal('left');
        $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical('center');
        // set border color
        $sheet->getParent()->getDefaultStyle()->getAlignment()->setWrapText(true);
        // Style the first row as bold text with a cohesive color scheme
        $sheet->getStyle(1)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '2d4154'],
            ],
        ]);
        // Add stripe color effect for alternating rows
        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle($row)->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => 'f2f2f2'],
                    ],
                ]);
            }
        }
        return [];
    }
}
