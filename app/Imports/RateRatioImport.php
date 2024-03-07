<?php

namespace App\Imports;

use App\Models\WarehouseRateRatio;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class RateRatioImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public $carrier_id;
    public $country_id;

    public function __construct($carrier_id, $country_id)
    {
        $this->carrier_id = $carrier_id;
        $this->country_id = $country_id;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            WarehouseRateRatio::firstOrCreate([
                'carrier_id' => $this->carrier_id,
                'country_id' => $this->country_id,
                'weight' => $row[0],
                'price' => $row[1],
            ]);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}