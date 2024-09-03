<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\Refund;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class DetailedSalesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
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
        $sale_calculation = $this->data['sale_calculation'];
        $invoice_cal = $sale_calculation;
        $refund_cal = $sale_calculation == 'invoice_date' ? 'refund_date' : $sale_calculation;
        $start_date = $this->data['start_date'];
        $end_date = $this->data['end_date'];

        $invoices = Invoice::where('user_id', $this->data['user_id'])->where('status', '=', 'paid')->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->get();
        $refunds = Refund::where('user_id', $this->data['user_id'])->where('status', '=', 'paid')->where($refund_cal, '>=', $start_date)->where($refund_cal, '<=', $end_date)->get();
        $data = $invoices->merge($refunds);

        return $data;
    }

    public function headings(): array
    {
        return [
            'Type',
            'Status',
            'ID',
            'Customer Name',
            'Date',
            'Cost(£)',
            'Sale(£)',
            'Revenue(£)',
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
            $data instanceof Invoice ? 'Invoice' : 'Refund',
            $data->status == 'paid' ? 'Paid' : ($data->due_date < date('Y-m-d') ? 'Overdue' : 'Pending'),
            $data instanceof Invoice ? $data->invoice_id : $data->refund_id,
            $data->customer->name,
            $data instanceof Invoice ? $data->invoice_date : $data->refund_date,
            $data->total - $data->revenue,
            $data->total,
            $data->revenue,
        ];
    }
}
