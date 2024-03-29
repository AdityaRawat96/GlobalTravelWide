<?php

namespace App\Exports;

use App\Models\Catalogue;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CataloguesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $catalogues = Catalogue::select(
            DB::raw("LPAD(id, 5, '0') as catalogue_id"),
            'name',
            'description',
            'status',
        )->get();

        return $catalogues;
    }

    public function headings(): array
    {
        return [
            'Catalogue ID',
            'Name',
            'Description',
            'Status',
        ];
    }
}
