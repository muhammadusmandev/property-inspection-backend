<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InspectionAreasItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        $areaNames = [
            'Bedroom',
            'Utility Room',
            'Conservatory',
            'En Suite',
            'Porch',
            'Living Room/Dining Room',
            'Living Room',
            'Dining Room',
            'Kitchen',
            'Kitchen/Dining Room',
            'Entrance',
            'Garage',
            'Toilet',
            'Stairs/Landing',
            'Studio Living Space',
            'Bathroom',
            'Entrance/Hallway',
            'Stairs'
        ];

        $areaIds = [];
        foreach ($areaNames as $area) {
            $areaIds[$area] = DB::table('inspection_areas')->insertGetId([
                'name' => $area,
                'is_default' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $itemNames = [
            'Windows',
            'Doors',
            'Flooring',
            'Walls',
            'Lighting',
            'Sink',
            'Ceiling',
            'Toilet',
            'Switches/Sockets',
            'Oven/Hob/Extractor Fan',
            'Heating',
            'Worktops',
            'Units',
            'Kitchen Units'
        ];

        $itemIds = [];
        foreach ($itemNames as $item) {
            $itemIds[$item] = DB::table('inspection_area_items')->insertGetId([
                'name' => $item,
                'is_default' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $areaItemsMap = [
            'Entrance' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Switches/Sockets', 'Walls', 'Windows'],
            'Entrance/Hallway' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Switches/Sockets', 'Walls', 'Windows'],
            'En Suite' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Walls', 'Windows'],
            'Kitchen' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Kitchen Units', 'Lighting', 'Oven/Hob/Extractor Fan', 'Switches/Sockets', 'Walls', 'Windows', 'Worktops'],
            'Kitchen/Dining Room' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Kitchen Units', 'Lighting', 'Oven/Hob/Extractor Fan', 'Switches/Sockets', 'Walls', 'Windows', 'Worktops'],
            'Bedroom' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Switches/Sockets', 'Walls', 'Windows'],
            'Living Room' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Switches/Sockets', 'Walls', 'Windows'],
            'Living Room/Dining Room' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Switches/Sockets', 'Walls', 'Windows'],
            'Dining Room' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Switches/Sockets', 'Walls', 'Windows'],
            'Porch' => ['Ceiling', 'Doors', 'Flooring', 'Lighting', 'Walls', 'Windows'],
            'Stairs' => ['Ceiling', 'Doors', 'Flooring', 'Lighting', 'Walls', 'Windows'],
            'Stairs/Landing' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Walls', 'Windows'],
            'Garage' => ['Ceiling', 'Doors', 'Flooring', 'Lighting', 'Walls'],
            'Studio Living Space' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Kitchen Units', 'Lighting', 'Oven/Hob/Extractor Fan', 'Switches/Sockets', 'Walls', 'Windows', 'Worktops'],
            'Utility Room' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Switches/Sockets', 'Units', 'Walls', 'Windows', 'Worktops'],
            'Bathroom' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Sink', 'Toilet', 'Walls', 'Windows'],
            'Toilet' => ['Ceiling', 'Doors', 'Flooring', 'Heating', 'Lighting', 'Sink', 'Toilet', 'Walls', 'Windows'],
            'Conservatory' => ['Doors', 'Flooring', 'Heating', 'Switches/Sockets', 'Windows'],
        ];

        foreach ($areaItemsMap as $areaName => $items) {
            $areaId = $areaIds[$areaName];

            foreach ($items as $itemName) {
                if (!isset($itemIds[$itemName])) {
                    $itemIds[$itemName] = DB::table('items')->insertGetId([
                        'name' => $itemName
                    ]);
                }

                DB::table('inspection_area_item')->insert([
                    'area_id' => $areaId,
                    'item_id' => $itemIds[$itemName],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
