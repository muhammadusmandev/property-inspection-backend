<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'Afghanistan', 'code' => 'AF', 'status' => 1],
            ['name' => 'Albania', 'code' => 'AL', 'status' => 1],
            ['name' => 'Algeria', 'code' => 'DZ', 'status' => 1],
            ['name' => 'Andorra', 'code' => 'AD', 'status' => 1],
            ['name' => 'Angola', 'code' => 'AO', 'status' => 1],
            ['name' => 'Argentina', 'code' => 'AR', 'status' => 1],
            ['name' => 'Australia', 'code' => 'AU', 'status' => 1],
            ['name' => 'Austria', 'code' => 'AT', 'status' => 1],
            ['name' => 'Azerbaijan', 'code' => 'AZ', 'status' => 1],
            ['name' => 'Bangladesh', 'code' => 'BD', 'status' => 1],
            ['name' => 'Belgium', 'code' => 'BE', 'status' => 1],
            ['name' => 'Brazil', 'code' => 'BR', 'status' => 1],
            ['name' => 'Canada', 'code' => 'CA', 'status' => 1],
            ['name' => 'China', 'code' => 'CN', 'status' => 1],
            ['name' => 'Denmark', 'code' => 'DK', 'status' => 1],
            ['name' => 'Egypt', 'code' => 'EG', 'status' => 1],
            ['name' => 'Finland', 'code' => 'FI', 'status' => 1],
            ['name' => 'France', 'code' => 'FR', 'status' => 1],
            ['name' => 'Germany', 'code' => 'DE', 'status' => 1],
            ['name' => 'Greece', 'code' => 'GR', 'status' => 1],
            ['name' => 'Hong Kong', 'code' => 'HK', 'status' => 1],
            ['name' => 'Iceland', 'code' => 'IS', 'status' => 1],
            ['name' => 'India', 'code' => 'IN', 'status' => 1],
            ['name' => 'Indonesia', 'code' => 'ID', 'status' => 1],
            ['name' => 'Iran', 'code' => 'IR', 'status' => 1],
            ['name' => 'Iraq', 'code' => 'IQ', 'status' => 1],
            ['name' => 'Ireland', 'code' => 'IE', 'status' => 1],
            ['name' => 'Israel', 'code' => 'IL', 'status' => 1],
            ['name' => 'Italy', 'code' => 'IT', 'status' => 1],
            ['name' => 'Japan', 'code' => 'JP', 'status' => 1],
            ['name' => 'Jordan', 'code' => 'JO', 'status' => 1],
            ['name' => 'Kenya', 'code' => 'KE', 'status' => 1],
            ['name' => 'Kuwait', 'code' => 'KW', 'status' => 1],
            ['name' => 'Luxembourg', 'code' => 'LU', 'status' => 1],
            ['name' => 'Malaysia', 'code' => 'MY', 'status' => 1],
            ['name' => 'Maldives', 'code' => 'MV', 'status' => 1],
            ['name' => 'Mexico', 'code' => 'MX', 'status' => 1],
            ['name' => 'Morocco', 'code' => 'MA', 'status' => 1],
            ['name' => 'Nepal', 'code' => 'NP', 'status' => 1],
            ['name' => 'Netherlands', 'code' => 'NL', 'status' => 1],
            ['name' => 'New Zealand', 'code' => 'NZ', 'status' => 1],
            ['name' => 'Nigeria', 'code' => 'NG', 'status' => 1],
            ['name' => 'Norway', 'code' => 'NO', 'status' => 1],
            ['name' => 'Oman', 'code' => 'OM', 'status' => 1],
            ['name' => 'Pakistan', 'code' => 'PK', 'status' => 1],
            ['name' => 'Philippines', 'code' => 'PH', 'status' => 1],
            ['name' => 'Poland', 'code' => 'PL', 'status' => 1],
            ['name' => 'Portugal', 'code' => 'PT', 'status' => 1],
            ['name' => 'Qatar', 'code' => 'QA', 'status' => 1],
            ['name' => 'Russia', 'code' => 'RU', 'status' => 1],
            ['name' => 'Saudi Arabia', 'code' => 'SA', 'status' => 1],
            ['name' => 'Singapore', 'code' => 'SG', 'status' => 1],
            ['name' => 'South Africa', 'code' => 'ZA', 'status' => 1],
            ['name' => 'South Korea', 'code' => 'KR', 'status' => 1],
            ['name' => 'Spain', 'code' => 'ES', 'status' => 1],
            ['name' => 'Sri Lanka', 'code' => 'LK', 'status' => 1],
            ['name' => 'Sweden', 'code' => 'SE', 'status' => 1],
            ['name' => 'Switzerland', 'code' => 'CH', 'status' => 1],
            ['name' => 'Thailand', 'code' => 'TH', 'status' => 1],
            ['name' => 'Turkey', 'code' => 'TR', 'status' => 1],
            ['name' => 'United Arab Emirates', 'code' => 'AE', 'status' => 1],
            ['name' => 'United Kingdom', 'code' => 'GB', 'status' => 1],
            ['name' => 'United States', 'code' => 'US', 'status' => 1],
            ['name' => 'Vietnam', 'code' => 'VN', 'status' => 1],
            ['name' => 'Yemen', 'code' => 'YE', 'status' => 1],
        ];

        DB::table('countries')->insert($countries);
    }
}
