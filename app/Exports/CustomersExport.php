<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $app_short_name = env('APP_SHORT', 'TW');
        // Append short name to the customer id

        $customers = Customer::select(
            DB::raw("CONCAT('C', LPAD(id, 5, '0')) as customer_id"),
            'name',
            'email',
            'phone',
            DB::raw("CONCAT('" . $app_short_name . "', LPAD(added_by, 5, '0')) as added_by"),
        )->get();

        return $customers;
    }

    public function headings(): array
    {
        return [
            'Customer ID',
            'Name',
            'Email',
            'Phone',
            'Added By',
        ];
    }
}
