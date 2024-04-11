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

class CommissionsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
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

        $affiliates = Affiliate::select(
            'id',
            DB::raw("CONCAT('" . $app_short_name . "', LPAD(id, 5, '0')) as affiliate_id"),
            'name as full_name',
            'commission'
        )->get();

        foreach ($affiliates as $index => $affiliate) {
            // only if the filter is not empty and exists filter the records
            $commission_calculation = $this->data['commission_calculation'];
            $invoice_cal = $commission_calculation;
            $refund_cal = $commission_calculation == 'invoice_date' ? 'refund_date' : $commission_calculation;
            $start_date = $this->data['start_date'];
            $end_date = $this->data['end_date'];

            $invoices_sum_total = Invoice::where('affiliate_id', $affiliate->id)->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->sum('total');
            $invoices_sum_revenue = Invoice::where('affiliate_id', $affiliate->id)->where($invoice_cal, '>=', $start_date)->where($invoice_cal, '<=', $end_date)->sum('revenue');
            $refunds_sum_total = Refund::where('affiliate_id', $affiliate->id)->where($refund_cal, '>=', $start_date)->where($refund_cal, '<=', $end_date)->sum('total');
            $refunds_sum_revenue = Refund::where('affiliate_id', $affiliate->id)->where($refund_cal, '>=', $start_date)->where($refund_cal, '<=', $end_date)->sum('revenue');

            $total = $invoices_sum_total + $refunds_sum_total;
            $revenue = $invoices_sum_revenue + $refunds_sum_revenue;
            $commission = $revenue * ($affiliate->commission / 100);

            $affiliates[$index]->commission_percentage = $affiliate->commission;
            $affiliates[$index]->commission = number_format(($commission), 2, '.', ',');
            $affiliates[$index]->total = number_format(($total), 2, '.', ',');
            $affiliates[$index]->revenue = number_format(($revenue), 2, '.', ',');
        }
        return $affiliates;
    }

    public function headings(): array
    {
        return [
            'Affiliate ID',
            'Name',
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
        ];
    }

    // Create mappings for the data
    public function map($data): array
    {
        return [
            $data->affiliate_id,
            $data->full_name,
            $data->commission_percentage,
            $data->total,
            $data->revenue,
            $data->commission,
        ];
    }
}
