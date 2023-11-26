<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Klass;
use App\Models\Entity;
use App\Models\Subject;
use App\Models\UserInfo;
use App\Models\Evaluatee;
use App\Models\SectionYear;
use App\Models\KlassSection;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $sys = SectionYear::all();
        // $users = User::factory(10)->create();
        // foreach ($sys as $sy) {
        //     $users = User::factory(10)->create();
        //     foreach ($users as $user) {
        //         $sy->users()->attach($user->id_number);
        //     }

        // }
        // foreach($users as $user) {
        //     $randomSys = SectionYear::inRandomOrder()->first();
        //     $user->sectionYears()->attach($randomSys->id);
        // }
        // User::factory(10)->create();
        // $subjects = ['math', 'science', 'english', 'history', 'social studies', 'art', 'music'] ;
        // foreach ($subjects as $subject) {
        //     Subject::factory()->create(['name' => $subject]);
        // }

        $entities = ['instructor','guard','canteen-staff'];
        foreach ($entities as $entity) {
            Entity::create(['entity_name' => $entity])->each(function($q){
                Evaluatee::factory(10)->create(['entity_id'=>$q->id]);
            });
        }

        $roles = ['student','admin','staff','chairperson'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        $roleForStudent = Role::where('name','student')->first();

        $evaluatees = Evaluatee::where('entity_id',1)->get();

        foreach ($evaluatees as $evaluatee) {
            $randomSubjects = Subject::inRandomOrder()->limit(3)->get();
            foreach ($randomSubjects as $randomSubject) {
                $evaluatee->subjects()->attach($randomSubject->id);
            }

        }

        $klasses = Klass::all();
        foreach ($klasses as $klass) {
            $randomeSections  = SectionYear::inRandomOrder()->limit(3)->get();
            foreach ($randomeSections as $randomSection) {
                KlassSection::factory()->create([
                    'klass_id' => $klass->id,
                    'section_year_id' => $randomSection->id,
                ]);
                $users = User::factory(10)->create(['role_id'=> $roleForStudent->id]);
                foreach ($users as $user) {
                    $randomSection->sectionYearsPerUser()->attach($user->id_number);
                    UserInfo::factory()->create(['user_id' => $user->id_number]);
                }
            }
        }

        $klasses = Klass::with([
                        'evaluatee',
                        'sectionYears' => function($q){
                            $q->with('sectionYearsPerUser');
                        }
                    ])->get();

            foreach ($klasses as $klass) {

                foreach( $klass->sectionYears as $sy){
                    foreach($sy->sectionYearsPerUser as $user){
                        $user->evaluatees()->syncWithoutDetaching($klass->evaluatee_id);
                    }
                }
            }



    }
}
