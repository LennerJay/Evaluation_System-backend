<?php

namespace App\Models;

use App\Models\Criteria;
use App\Models\Rating;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['question','criteria_id'];

    protected $hidden = ['updated_at', 'created_at'];


    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    // public function users(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class,'ratings',);
    // }
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class,Rating::class,'question_id','id_number','id','evaluator_id');
    }
    public function scopeCountRatingsBySubject(Builder $query,$id,$rating)
    {
        $query->withCount([
                'ratings' => function($query)use($id,$rating){
                    $query->where('evaluator_id',$id)
                          ->where('rating',$rating);
                }
            ]);
    }
    public function scopeWithAvgRating(Builder $q,$query)
    {
       dd($query->count());
    //    dd($q);
        // return  $q->withAvg([
        //     'ratings' =>function($query)use($id,$rating){
        //         $query->whereHasMorph(
        //                 'ratingable',
        //                 Instructor::class,
        //                 function(Builder $q)use($id,$rating){
        //                     $q->where('ratingable_id',$id)
        //                         ->where('rating',$rating);
        //                 });
        //     }
        // ],'rating');
}
    public function mean():Attribute
    {
        return new Attribute(
            get: function($value,$attribute){
                $totalEvaluator =  $attribute['NI'] + $attribute['F'] +$attribute['S'] +$attribute['VS'] + $attribute['O'];
                $calculate = $attribute['NI'] + ($attribute['F'] * 2) + ($attribute['S'] * 3) + ($attribute['VS'] * 4) + ($attribute['O'] * 5) ;
                $mean = $calculate / $totalEvaluator ;

                return  array(
                    'mean' => $mean,
                    'QD' => $this->findQd($mean)
                );
            },
        );
    }

    private function findQd($mean)
    {
        // if ($mean >= 4.21 && $mean <= 5) {
        //     return 'O';
        // } elseif ($mean >= 3.41 && $mean < 4.21) {
        //     return 'VS';
        // } elseif ($mean >= 2.61 && $mean < 3.41) {
        //     return 'S';
        // } elseif ($mean >= 1.81 && $mean < 2.61) {
        //     return 'F';
        // } elseif ($mean >= 1 && $mean < 1.81) {
        //     return 'IN';
        // } else {
        //     return 'FUCK';
        // }

        if ($mean >= 1 && $mean < 1.81 ) {
            return 'IN';
        } elseif ($mean >= 1.81 && $mean < 2.61) {
            return 'F';
        } elseif ($mean >= 2.61 && $mean < 3.41) {
            return 'S';
        } elseif ($mean >= 3.41 && $mean < 4.21) {
            return 'VS';
        } elseif ($mean >= 4.21 && $mean <= 5) {
            return 'O';
        }


    }
}
