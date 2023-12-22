<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rating;
use App\Models\Evaluatee;
use App\Models\Questionaire;
use Illuminate\Database\Seeder;

class RatingGuardSeeder extends Seeder
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
                                    ->where('entity_id',2)
                                    ->latest('updated_at')
                                    ->first();
                                    if ($questionnaire) {
                                        foreach ($questionnaire->criterias as $criteria) {
                                            foreach ($criteria->questions as $question) {
                                                $questions[] = $question;
                                            }
                                        }
                                    }

            $users = User::inRandomOrder()->limit(100)->get();

            $evaluatees = Evaluatee::where('entity_id',2)->get();
            foreach($evaluatees as $evaluatee){
                foreach($users as $user){
                    foreach($questions as $question){
                        $randomRAte = rand(1,5);
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
