<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpensesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    protected $data;

    // Constructor to accept data for collection
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $start_date = $this->data['start_date'];
        $end_date = $this->data['end_date'];
        $expenses = Expense::select(
            DB::raw("DATE_FORMAT(date, '%d-%m-%Y') as date"),
            'amount',
            'description',
        )->where('date', '>=', $start_date)->where('date', '<=', $end_date)->get();

        return $expenses;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Amount (£)',
            'Description',
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
            $data->date,
            $data->amount,
            $data->description,
        ];
    }
}
