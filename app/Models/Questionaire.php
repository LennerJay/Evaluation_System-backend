<?php

namespace App\Models;

use App\Models\Entity;
use App\Models\Criteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Questionaire extends Model
{
    use HasFactory;


    protected $fillable = [
        'entity_id',
        'title',
        'description',
        'semester',
        'school_year',
        'max_respondents',
        'status'
    ];

    protected $hidden = ['created_at','pivot'];

    public function criterias(): BelongsToMany
    {
        return $this->belongsToMany(Criteria::class,'criteria_questionaire')->withTimestamps();
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function scopeQuestionaireWithCriteria(Builder $query, $id= null)
    {
        if(!$id){
            return $query->with('criterias');
        }
        return $query->with('criterias')->where('id', 1);
    }

    public function getAliasedRatingsAttribute()
    {
        return $this->ratings;
    }

    public function scopeEvaluationFormFor(Builder $query,$id)
    {
        $query->with([
            'criterias' => function($query)use($id){
                $query->with([
                    'questions'=> function($q)use($id){
                        $q->withCount([
                            'ratings as NI'=> function($q)use($id){
                                $q->ratingsBySubject($id,1);
                            },
                            'ratings as F'=> function($q)use($id){
                                $q->ratingsBySubject($id,2);
                            },
                            'ratings as S'=> function($q)use($id){
                                $q->ratingsBySubject($id,3);
                            },
                            'ratings as VS'=> function($q)use($id){
                                $q->ratingsBySubject($id,4);
                            },
                            'ratings as O'=> function($q)use($id){
                                $q->ratingsBySubject($id,5);
                            },
                        ])
                        ->withAvg([
                            'ratings' => function($query)use($id){
                                $query->where('evaluatee_id',$id);
                            }
                            ],'rating')
                        ;
                    }
                ]);
            }
            ])
        ;
    }
}
