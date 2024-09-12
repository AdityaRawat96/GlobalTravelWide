<?php

namespace App\Exports;

use App\Models\Reminder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class RemindersExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $app_short_name = env('APP_SHORT', 'TW');
        $reminders = Reminder::select(
            DB::raw("LPAD(id, 5, '0') as reminder_id"),
            DB::raw("CONCAT('" . $app_short_name . "', LPAD(id, 5, '0')) as user_id"),
            'customer_id',
            DB::raw("DATE_FORMAT(date, '%d-%m-%Y %h:%i %p') as date"),
        )->get();

        return $reminders;
    }

    public function headings(): array
    {
        return [
            'Reminder ID',
            'Created By',
            'Customer Name',
            'Date',
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

    // Create mappings for the data
    public function map($data): array
    {
        return [
            $data->reminder_id,
            $data->user_id,
            $data->customer->name,
            $data->date,
        ];
    }
}
