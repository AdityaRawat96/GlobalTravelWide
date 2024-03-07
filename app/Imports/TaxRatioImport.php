<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\WarehouseRatio;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TaxRatioImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public $country_id;

    public function __construct($country_id)
    {
        $this->country_id = $country_id;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            WarehouseRatio::firstOrCreate([
                'country_id' => $this->country_id,
                'min_price' => $row[0],
                'max_price' => $row[1],
                'tax_ratio' => $row[2],
            ]);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}