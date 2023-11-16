<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Klass;
use App\Models\Subject;
use App\Models\UserInfo;
use App\Models\Evaluatee;
use App\Models\KlassSection;
use App\Models\SectionYear;
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
        $this->call([SubjectSectionSeeder::class]);
        $evaluatees = Evaluatee::factory(10)->create();

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
                // $klass->sectionYears()->attach($randomSection->id);
                KlassSection::factory()->create([
                    'klass_id' => $klass->id,
                    'section_year_id' => $randomSection->id,
                ]);
                $users = User::factory(10)->create();
                foreach ($users as $user) {
                    $randomSection->sectionYearsPerUser()->attach($user->id_number);
                    UserInfo::factory()->create(['user_id' => $user->id_number]);
                }
            }

        }

        $klasses = Klass::with([
                        'sectionYears' => function($q){
                            $q->with('sectionYearsPerUser');
                        },
                        'evaluatee'
        ])->get();

            // foreach ($klasses as $klass) {

            //     foreach( $klass->section_years as $sy){
            //         foreach($sy->section_years_per_user as $user){
            //             $user->evaluatees()->syncWithoutDetaching($klass->evaluatee_id);
            //         }

            //     }
            // }


    }
}
