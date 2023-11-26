<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\Evaluatee;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = ['instructor','guard','canteen-staff'];
        foreach ($entities as $entity) {
            Entity::create(['entity_name' => $entity]);
        }
        $guardId = Entity::where('entity_name','guard')->first();
        Evaluatee::factory(5)->create(['entity_id' => $guardId]);
        $canteenStaffId = Entity::where('entity_name','canteen-staff')->first();
        Evaluatee::factory(5)->create(['entity_id' => $canteenStaffId]);

    }
}
