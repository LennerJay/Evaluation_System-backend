<?php

namespace Database\Seeders;

use App\Models\Klass;
use App\Models\Entity;
use App\Models\Subject;
use App\Models\Evaluatee;
use App\Models\Department;
use Illuminate\Database\Seeder;
use App\Models\EvaluateeDepartment;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = ['math', 'science', 'english', 'history', 'social studies', 'art', 'music','PE'] ;
        foreach ($subjects as $subject) {
            Subject::factory()->create(['name' => $subject]);
        }


        // $departments = Department::all();
        // $instructorId = Entity::where('entity_name','instructor')->first();

        // foreach($departments as $department){
        //     Evaluatee::factory(10)->create(['entity_id'=>$instructorId])->each(function($evaluatee)use($department){
        //        $eD= EvaluateeDepartment::create([
        //             'evaluatee_id' => $evaluatee->id,
        //             'department_id' => $department->id
        //         ]);
        //         $randomSubjects = Subject::inRandomOrder()->take(3)->get();
        //         foreach ($randomSubjects as $subject){
        //             Klass::create([
        //                 'subject_id' => $subject->id,
        //                 'e_d_id'=> $eD->id
        //             ]);
        //         }

        //     });
        // }

        // Evaluatee::factory(10)->create(['entity_id'=>$instructorId])->each(function($evaluatee){
        //     $randomDepartments = Department::inRandomOrder()->take(2)->get();
        //     foreach($randomDepartments as $department){
        //         $eD= EvaluateeDepartment::create([
        //             'evaluatee_id' => $evaluatee->id,
        //             'department_id' => $department->id
        //         ]);
        //         $randomSubjects = Subject::inRandomOrder()->take(1)->get();
        //         foreach ($randomSubjects as $subject){
        //             Klass::create([
        //                 'subject_id' => $subject->id,
        //                 'e_d_id'=> $eD->id
        //             ]);
        //         }
        //     }
        // });
    }
}
