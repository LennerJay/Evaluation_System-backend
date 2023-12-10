<?php
namespace App\Service\Controller;

use App\Models\Rating;
use App\Models\Evaluatee;


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
                            ->where('evaluator_id',auth()->user()->id_number)->get();

        return $ratings;
    }

}
