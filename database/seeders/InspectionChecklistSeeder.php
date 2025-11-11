<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InspectionChecklist;

class InspectionChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // General condition & structural
            ['label' => 'Property generally well-maintained', 'type' => 'Structural & General Condition'],
            ['label' => 'Roof in good condition', 'type' => 'Structural & General Condition'],
            ['label' => 'Structural issues (walls, ceilings, floors)', 'type' => 'Structural & General Condition'],
            ['label' => 'Gutters and downpipes clear', 'type' => 'Structural & General Condition'],
            ['label' => 'Evidence of damp, condensation, or leaks', 'type' => 'Structural & General Condition'],

            // Safety & Security
            ['label' => 'Smoke / heat detectors tested and working', 'type' => 'Safety & Security'],
            ['label' => 'Fire extinguishers present and functional', 'type' => 'Safety & Security'],
            ['label' => 'Windows and doors lock properly', 'type' => 'Safety & Security'],
            ['label' => 'Carbon monoxide detectors tested and working', 'type' => 'Safety & Security'],
            ['label' => 'Emergency exits accessible', 'type' => 'Safety & Security'],

            // Plumbing & Water
            ['label' => 'Water supply and pressure adequate', 'type' => 'Plumbing & Water'],
            ['label' => 'Hot water system working', 'type' => 'Plumbing & Water'],
            ['label' => 'Faucets, showers, and toilets functioning', 'type' => 'Plumbing & Water'],
            ['label' => 'Evidence of leaking pipes or blocked drains', 'type' => 'Plumbing & Water'],

            // Electrical & HVAC
            ['label' => 'Power outlets and light fixtures working', 'type' => 'Electrical & HVAC'],
            ['label' => 'Circuit breakers functional', 'type' => 'Electrical & HVAC'],
            ['label' => 'Heating system operational', 'type' => 'Electrical & HVAC'],
            ['label' => 'Cooling / air conditioning operational', 'type' => 'Electrical & HVAC'],
            ['label' => 'Adequate ventilation in all rooms', 'type' => 'Electrical & HVAC'],

            // Interior condition
            ['label' => 'Cleanliness of interior spaces', 'type' => 'Interior Condition'],
            ['label' => 'Condition of floors, carpets, and tiles', 'type' => 'Interior Condition'],
            ['label' => 'Evidence of smoking', 'type' => 'Interior Condition'],
            ['label' => 'Evidence of pets', 'type' => 'Interior Condition'],
            ['label' => 'Evidence of non-tenants', 'type' => 'Interior Condition'],

            // Exterior & Grounds
            ['label' => 'Garden/yard maintained, fences and gates sound', 'type' => 'Exterior & Grounds'],
        ];

        foreach ($items as $item) {
            InspectionChecklist::create($item);
        }
    }
}
