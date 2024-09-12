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

class SalesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
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
        $app_short_name = env('APP_SHORT', 'TW');
        // Append short name to the quotation id

        $users = User::select(
            'id',
            DB::raw("CONCAT('" . $app_short_name . "', LPAD(id, 5, '0')) as user_id"),
            DB::raw("CONCAT(first_name, ' ', last_name) as full_name"),
        )->get();

        foreach ($users as $index => $user) {
            // only if the filter is not empty and exists filter the records
            $sale_calculation = $this->data['sale_calculation'];
            $invoice_cal = $sale_calculation;
            $refund_cal = $sale_calculation == 'invoice_date' ? 'refund_date' : $sale_calculation;
            $start_date = $this->data['start_date'];
            $end_date = $this->data['end_date'];

            $invoices_sum_total = Invoice::where('user_id', $user->id)->where('status', '=', 'paid')->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->sum('total');
            $invoices_sum_revenue = Invoice::where('user_id', $user->id)->where('status', '=', 'paid')->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->sum('revenue');
            $refunds_sum_total = Refund::where('user_id', $user->id)->where('status', '=', 'paid')->where($refund_cal, '>=', $start_date)->where($refund_cal, '<=', $end_date)->sum('total');
            $refunds_sum_revenue = Refund::where('user_id', $user->id)->where('status', '=', 'paid')->where($refund_cal, '>=', $start_date)->where($refund_cal, '<=', $end_date)->sum('revenue');

            $total = $invoices_sum_total + $refunds_sum_total;
            $revenue = $invoices_sum_revenue + $refunds_sum_revenue;
            $cost = $total - $revenue;

            $users[$index]->cost = number_format(($cost), 2, '.', ',');
            $users[$index]->total = number_format(($total), 2, '.', ',');
            $users[$index]->revenue = number_format(($revenue), 2, '.', ',');
        }
        return $users;
    }

    public function headings(): array
    {
        return [
            'User ID',
            'Name',
            'Cost(£)',
            'Sale(£)',
            'Revenue(£)',
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
            $data->user_id,
            $data->full_name,
            $data->cost,
            $data->total,
            $data->revenue,
        ];
    }
}
