<?php

namespace App\Exports;

use App\Models\Affiliate;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AffiliatesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $app_short_name = env('APP_SHORT', 'TW');
        // Append short name to the affiliate id

        $affiliates = Affiliate::select(
            DB::raw("CONCAT('C', LPAD(id, 5, '0')) as affiliate_id"),
            'name',
            'email',
            'phone',
            'commission',
            DB::raw("CONCAT('" . $app_short_name . "', LPAD(added_by, 5, '0')) as added_by"),
        )->get();

        return $affiliates;
    }

    public function headings(): array
    {
        return [
            'Affiliate ID',
            'Name',
            'Email',
            'Phone',
            'Commission(%)',
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
