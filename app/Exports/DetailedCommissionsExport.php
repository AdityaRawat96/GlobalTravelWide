<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\Refund;
use App\Models\Affiliate;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class DetailedCommissionsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
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
        $commission_calculation = $this->data['commission_calculation'];
        $invoice_cal = $commission_calculation;
        $refund_cal = $commission_calculation == 'invoice_date' ? 'refund_date' : $commission_calculation;
        $start_date = $this->data['start_date'];
        $end_date = $this->data['end_date'];

        $invoices = Invoice::where('affiliate_id', $this->data['affiliate_id'])->where('status', '=', 'paid')->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->get();
        $refunds = Refund::where('affiliate_id', $this->data['affiliate_id'])->where('status', '=', 'paid')->where($refund_cal, '>=', $start_date)->where($refund_cal, '<=', $end_date)->get();
        $data = $invoices->merge($refunds);

        // Calculate total sale, revenue and commission
        $totalSale = $data->sum('total');
        $totalRevenue = $data->sum('revenue');
        $totalCommission = $data->sum(function ($item) {
            return $item->revenue * ($item->affiliate->commission / 100);
        });

        // Append totals row
        $data->push((object)[
            'type' => '',
            'status' => '',
            'id' => '',
            'customer_name' => '',
            'date' => '',
            'commission' => 'Total:',
            'sale' => $totalSale,
            'revenue' => $totalRevenue,
            'commission_total' => $totalCommission,
        ]);


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
            'Commission(%)',
            'Sale(£)',
            'Revenue(£)',
            'Commission(£)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getParent()->getDefaultStyle()->getAlignment()->setHorizontal('left');
        $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical('center');

        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '2d4154']]],
            // Style the last row as bold text
            $sheet->getHighestRow() => ['font' => ['bold' => true]],
        ];
    }

    // Create mappings for the data
    public function map($data): array
    {
        if ($data instanceof Invoice || $data instanceof Refund) {
            return [
                $data instanceof Invoice ? 'Invoice' : 'Refund',
                $data->status == 'paid' ? 'Paid' : ($data->due_date < date('Y-m-d') ? 'Overdue' : 'Pending'),
                $data instanceof Invoice ? $data->invoice_id : $data->refund_id,
                $data->customer->name,
                $data instanceof Invoice ? $data->invoice_date : $data->refund_date,
                $data->affiliate->commission,
                $data->total,
                $data->revenue,
                $data->revenue * ($data->affiliate->commission / 100),
            ];
        } else {
            // Handle the case where $data is an instance of stdClass
            return [
                '',
                '',
                '',
                '',
                '',
                'Total:',
                $data->sale,
                $data->revenue,
                $data->commission_total,
            ];
        }
    }
}
