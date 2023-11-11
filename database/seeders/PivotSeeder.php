<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Questionaire;
use Illuminate\Database\Seeder;

class PivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $questionaires = Questionaire::all();
        $departments = Department::all();


        foreach($questionaires as $questionaire){
            foreach($departments as $department){
                $department->questionaires()->attach($questionaire->id);
            }
        }
    }
}
