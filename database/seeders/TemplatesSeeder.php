<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class TemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        $templatesMap = [
            'House' => [
                'Entrance/Hallway', 'Toilet', 'Living Room', 'Kitchen', 'Utility Room', 'Stairs/Landing', 'Bathroom', 'Bedroom',
            ],
            'Flat / Apartment' => [
                'Entrance/Hallway', 'Living Room', 'Kitchen', 'Bathroom', 'Bedroom',
            ],
            'Upstairs Flat / Apartment' => [
                'Stairs/Landing', 'Living Room', 'Kitchen', 'Bathroom', 'Bedroom',
            ],
            'Studio Flat / Apartment' => [
                'Studio Living Space', 'En Suite',
            ],
        ];

        $areas = DB::table('inspection_areas')->pluck('id', 'name')->toArray();

        foreach ($templatesMap as $templateName => $areaNames) {
            $templateId = DB::table('templates')->insertGetId([
                'name' => $templateName,
                'is_default' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $pivotData = [];

            foreach ($areaNames as $areaName) {
                if (!isset($areas[$areaName])) {
                    throw new \Exception("Area '{$areaName}' not found in database. Seeder stopped.");
                }

                $pivotData[] = [
                    'inspection_area_id' => $areas[$areaName],
                    'template_id' => $templateId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('template_inspection_areas')->insert($pivotData);
        }
    }
}
