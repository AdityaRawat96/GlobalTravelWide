<?php

namespace App\Exports;

use App\Models\Query;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class QueriesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $app_short_name = env('APP_SHORT', 'TW');
        $queries = Query::select(
            DB::raw("LPAD(id, 5, '0') as query_id"),
            DB::raw("CONCAT('" . $app_short_name . "', LPAD(id, 5, '0')) as user_id"),
            'customer_id',
            DB::raw("DATE_FORMAT(date, '%d-%m-%Y') as date"),
            'status',
        )->get();

        return $queries;
    }

    public function headings(): array
    {
        return [
            'Query ID',
            'Created By',
            'Customer Name',
            'Contact',
            'Date',
            'Status',
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

    // Create mappings for the data
    public function map($data): array
    {
        return [
            $data->query_id,
            $data->user_id,
            $data->customer->name,
            $data->customer->phone,
            $data->date,
            ucfirst($data->status),
        ];
    }
}
