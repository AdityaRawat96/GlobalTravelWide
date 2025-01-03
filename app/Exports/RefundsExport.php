<?php

namespace App\Exports;

use App\Models\Refund;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class RefundsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
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
        // Append short name to the refund id

        $refunds = Refund::leftJoin('customers', 'refunds.customer_id', '=', 'customers.id')
            ->select(
                DB::raw("CONCAT(UCASE(LEFT(refunds.status, 1)), SUBSTRING(refunds.status, 2)) as status"),
                'refunds.refund_id',
                'refunds.ref_number',
                DB::raw("CONCAT('" . $app_short_name . "', LPAD(refunds.user_id, 5, '0')) as user_id"),
                DB::raw("IFNULL(CONCAT('C', LPAD(refunds.customer_id, 5, '0')), 'N/A') as customer_id"),
                DB::raw("IFNULL(customers.name, 'N/A') as customer_name"),
                DB::raw("DATE_FORMAT(refunds.refund_date, '%d-%m-%Y') as refund_date"),
                'refunds.total',
            );
        if ($this->data['date'] != null) {
            $params = explode(',', $this->data['date']);
            $refunds = $refunds->where('refunds.refund_date', $params[0], $params[1]);
        }

        if ($this->data['company'] != null) {
            $params = explode(',', $this->data['company']);
            $refunds = $refunds->where('refunds.company_id', $params[0], $params[1]);
        }

        $refunds = $refunds->get();

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
            $data->status,
            $data->refund_id,
            $data->ref_number,
            $data->user_id,
            $data->customer_id,
            $data->customer_name,
            $data->refund_date,
            $data->total ? $data->total : '0.00',
        ];
    }
}
