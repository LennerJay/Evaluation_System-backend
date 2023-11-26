<?php

namespace Database\Seeders;

use App\Models\Klass;
use App\Models\klassSection;
use App\Models\SectionYearDepartment;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KlassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $klasses = Klass::all();
        foreach ($klasses as $klass){
            $syds = SectionYearDepartment::inRandomOrder()->take(4)->get();
            foreach ($syds as $syd){
                klassSection::factory()->create([
                    's_y_d_id'=>$syd->id,
                    'klass_id'=>$klass->id
                ]);
            }
        }

    }
}
