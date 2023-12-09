<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Entity;
use App\Models\Evaluatee;
use App\Models\KlassDetails;
use App\Models\SectionYear;
use Illuminate\Database\Seeder;
use App\Models\SectionYearDepartment;
use App\Models\Subject;

class InstructorPerDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();
        $entity = Entity::where('entity_name','instructor')->first();
        foreach($departments as $department){
            $evaluatees = Evaluatee::factory(10)->create(['entity_id'=> $entity->id]);
           foreach( $evaluatees as $evaluatee){
            $randomSubjects = Subject::inRandomOrder()->take(3)->get();
                foreach($randomSubjects as $randomSubject){
                    $randomSYDs = SectionYearDepartment::where('department_id',$department->id)->inRandomOrder()->take(3)->get();
                    foreach($randomSYDs as $randomSYD){
                        KlassDetails::factory()->create([
                            's_y_d_id'=>$randomSYD->id,
                            'subject_id'=> $randomSubject->id,
                            'evaluatee_id'=> $evaluatee->id
                        ]);

                    }
                }
           }
        }

        $evaluatees1 = Evaluatee::factory(5)->create(['entity_id'=> $entity->id]);
        $evaluatees2 = Evaluatee::factory(5)->create(['entity_id'=> $entity->id]);

        foreach($evaluatees1 as $evaluatee){
            $randombBsit = SectionYearDepartment::where('department_id',1)->inRandomOrder()->take(2)->get();
            foreach($randombBsit as $bsit){
                $randomSubjects = Subject::inRandomOrder()->take(2)->get();
                foreach($randomSubjects as $randomSubject){
                    KlassDetails::factory()->create([
                        's_y_d_id'=>$bsit->id,
                        'subject_id'=> $randomSubject->id,
                        'evaluatee_id'=> $evaluatee->id
                    ]);
                }

            }
            $randomBshrm = SectionYearDepartment::where('department_id',2)->inRandomOrder()->take(2)->get();
            foreach($randomBshrm as $bshrm){
                $randomSubjects = Subject::inRandomOrder()->take(2)->get();
                foreach($randomSubjects as $randomSubject){
                    KlassDetails::factory()->create([
                        's_y_d_id'=> $bshrm->id,
                        'subject_id'=> $randomSubject->id,
                        'evaluatee_id'=> $evaluatee->id
                    ]);
                }
            }
        }

        foreach($evaluatees2 as $evaluatee){
            $randomBeed = SectionYearDepartment::where('department_id',3)->inRandomOrder()->take(2)->get();
            foreach($randomBeed as $beed){
                $randomSubjects = Subject::inRandomOrder()->take(2)->get();
                foreach($randomSubjects as $randomSubject){
                    KlassDetails::factory()->create([
                        's_y_d_id'=> $beed->id,
                        'subject_id'=> $randomSubject->id,
                        'evaluatee_id'=> $evaluatee->id
                    ]);
                }

            }
            $randomBsed = SectionYearDepartment::where('department_id',4)->inRandomOrder()->take(2)->get();
            foreach($randomBsed as $bsed){
                $randomSubjects = Subject::inRandomOrder()->take(2)->get();
                foreach($randomSubjects as $randomSubject){
                    KlassDetails::factory()->create([
                        's_y_d_id'=> $bsed->id,
                        'subject_id'=> $randomSubject->id,
                        'evaluatee_id'=> $evaluatee->id
                    ]);
                }
            }


        }

    }
}
