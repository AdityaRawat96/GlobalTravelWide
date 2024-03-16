<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $app_short_name = env('APP_SHORT', 'TW');
        // Append short name to the user id

        $users = User::select(
            DB::raw("CONCAT('" . $app_short_name . "', LPAD(id, 5, '0')) as user_id"),
            DB::raw("CONCAT(first_name, ' ', last_name) as full_name"),
            'role',
            'email',
            'phone',
            'status',
        )->get();

        return $users;
    }

    public function headings(): array
    {
        return [
            'User ID',
            'Full Name',
            'Role',
            'Email',
            'Phone',
            'Status',
        ];
    }
}
