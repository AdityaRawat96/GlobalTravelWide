<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create intital 2 companies
        Company::create([
            'name' => 'Global TravelWide',
            'logo' => 'companies/logo_1.png',
            'description' => 'Global TravelWide',
        ]);

        Company::create([
            'name' => 'OnTime',
            'logo' => 'companies/logo_2.png',
            'description' => 'OnTime',
        ]);
    }
}
