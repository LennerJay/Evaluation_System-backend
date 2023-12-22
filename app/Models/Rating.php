<?php

namespace App\Models;

use App\Models\User;
use App\Models\Question;
use App\Models\Evaluatee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluator_id',
        'question_id',
        'evaluatees_id',
        'rating'
    ];

    protected $hidden = ['updated_at', 'created_at'];

    public function evaluatees(): BelongsTo
    {
        return $this->belongsTo(Evaluatee::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'evaluator_id','id_number');

    }

    public function scopeQuestionRatingCount(Builder $query,$qid,$rating)
    {
        // return $query->whereHasMorph('ratingable',Instructor::class, function(Builder $q)use($rating){
        //     $q->where('rating', $rating);
        // })->get();
        // return $query->withCount(['rating' => function($q)use($rating){
        //     $q->where('rating', $rating)->get();
        // }]);
        return $query->where('question_id',$qid)
                     ->where('rating',$rating)->count();
    }
    // private function scopeSearchUser()
    // {
    //     return $this->where();
    // }
    // public function scopeQuestionRatingCountBySubject(Builder $query)
    // {

    // }
    public function scopeRatingsBySubject(Builder $query,$instructor_id,$rating)
    {
        $query->where('evaluatee_id',$instructor_id)
        ->where('rating',$rating);

        // $query->join('ratings', function ($join) use ($instructor_id, $rating) {
        //     $join->on('ratings.question_id', '=', 'questions.id')
        //          ->where('ratings.evaluatee_id', $instructor_id)
        //          ->where('ratings.rating', $rating);
        // });
    }
}
