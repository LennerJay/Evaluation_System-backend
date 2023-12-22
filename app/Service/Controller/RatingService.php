<?php
namespace App\Service\Controller;

use App\Http\Resources\RatingResource;
use App\Http\Resources\RatingsSummaryQuestionaire;
use App\Models\Rating;
use App\Models\Evaluatee;
use App\Http\Resources\RatingsSummaryResource;
use App\Models\EvaluateeUser;
use App\Models\Questionaire;
use stdClass;

class RatingService {

    public function saveRatings($request)
    {
        $evaluatee = Evaluatee::findOrFail($request->instructorId);
        $evaluatee->ratings()->createMany($request->val);
        $evaluatee->users()->updateExistingPivot($request->user_id,['is_done' => 1,'questionaire_id'=>$request->questionaire_id]);

        return 'ratings successfully created';
    }

    public function ratingsSummary($request)
    {
        $ratings = Rating:: with([
                                'question' => function($q){
                                    $q->with('criteria');
                                }
                            ])
                            ->where('evaluatee_id',$request->evaluatee_id)
                            ->where('evaluator_id',auth()->user()->id_number)
                            ->get();
        $ratingsSummary = RatingsSummaryResource::collection( $ratings);
        $res = EvaluateeUser::with([
                                'questionaire' => function ($q) {
                                    $q->select(['id', 'title', 'description', 'semester', 'school_year']);
                                }
                            ])
                            ->where('user_id', auth()->user()->id_number)
                            ->where('evaluatee_id', $request->evaluatee_id)
                            ->select('questionaire_id')
                            ->first();
        $questioanire =  RatingsSummaryQuestionaire::make($res);

        $result = new stdClass;

        $result->questionaire = $questioanire;
        $result->ratingSummary = $ratingsSummary;
        return $result;

    }

    public function getOutcomeRatingsSummary($request)
    {
        $res = Questionaire::evaluationFormFor($request->evaluatee_id)
                            ->where('entity_id',$request->entity_id)
                            ->where('status',1)
                            ->first();
        return $res;
    }

    public function fetchRatingInfo($request)
    {
        $res = Rating::with([
                        'user'=>function($q){
                            $q->with([
                                'userInfo',
                                'sectionYearDepartments'=>function($q){
                                    $q->with([
                                        'department',
                                        'sectionYear'
                                    ]);
                                }
                            ]);
                        },
                        'question'
                    ])
                    ->where('evaluatee_id', $request->evaluatee_id)
                    ->where('question_id', $request->question_id)
                    ->where('rating', $request->rating)
                    ->get();

        return RatingResource::collection($res);
        // return $res;
    }


}
