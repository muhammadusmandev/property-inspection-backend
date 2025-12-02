<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\InspectionAreasItemsTableSeeder;
use Database\Seeders\SubscriptionPlansSeeder;
use Database\Seeders\InspectionChecklistSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(InspectionAreasItemsTableSeeder::class);
        $this->call(TemplatesSeeder::class);     // must after InspectionAreasItemsTableSeeder
        $this->call(SubscriptionPlansSeeder::class); 
        $this->call(InspectionChecklistSeeder::class); 
    }
}
