<?php
namespace App\Service\Controller;

use App\Models\Evaluatee;


class RatingService {

    public function saveRatings($request)
    {
        $evaluatee = Evaluatee::findOrFail($request->instructorId);
        $evaluatee->ratings()->createMany($request->val);
        $evaluatee->users()->updateExistingPivot($request->user_id,['is_done' => 1]);

        return 'ratings successfully created';
    }

}
