<?php

namespace Database\Seeders;

use App\Models\Evaluatee;
use App\Models\Questionaire;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingInstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [];
        $questionnaire = Questionaire::with([
                                        'criterias'=>function($q){
                                            $q->with('questions');
                                        }
                                    ])
                                    ->where('status',1)
                                    ->where('entity_id',1)
                                    ->latest('updated_at')
                                    ->first();
                                    if ($questionnaire) {
                                        foreach ($questionnaire->criterias as $criteria) {
                                            foreach ($criteria->questions as $question) {
                                                $questions[] = $question;
                                            }
                                        }
                                    }


        $usersCollection = collect();
        $evaluatees = Evaluatee::with([
            'SectionYearDepartments' => function($q){
                $q->with('users');
            },
        ])->where('entity_id',1)->get();
            foreach($evaluatees as $evaluatee){
                foreach($evaluatee->SectionYearDepartments as $syd){
                    $usersCollection = $usersCollection->concat($syd->users);
                }
                $randomizedUsers = $usersCollection->shuffle();
                $random100Users = $randomizedUsers->take(100);
                foreach($random100Users as $user){
                    foreach($questions as $question){
                        $randomRAte = mt_rand(1,5);
                        Rating::create([
                            'question_id' => $question->id,
                            'evaluator_id'=> $user->id_number,
                            'evaluatee_id' =>$evaluatee->id,
                            'rating'=>$randomRAte
                        ]);
                    }
                    $evaluatee->users()->attach($user->id_number,['is_done' => 1,'questionaire_id'=>$questionnaire->id]);
                }


            }


    }
}
