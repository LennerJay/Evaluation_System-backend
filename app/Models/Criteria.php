<?php

namespace App\Models;

use App\Models\Question;
use App\Models\Rating;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = ['description'];
    // protected $hidden = [];
    protected $hidden = ['updated_at', 'created_at','pivot'];

    public function questionaire(): BelongsToMany
    {
        return $this->BelongsToMany(Questionaire::class,'criteria_questionaire')->withTimestamps();
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
    public function ratings(): HasManyThrough
    {
        return $this->hasManyThrough(Rating::class,Question::class);
    }

    public function scopeQuestionWithRatingsForm(Builder $query,$id)
    {

    }
}
