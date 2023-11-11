<?php

namespace App\Models;

use App\Models\User;
use App\Models\Evaluatee;
use App\Models\Questionaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['department'];

    public function users()
    {
      return $this->morphedByMany(User::class, 'departmentable')->withTimestamps();
    }

    public function evaluatees()
    {
        return $this->morphedByMany(Evaluatee::class,'departmentable')->withTimestamps();
    }

    public function questionaires(): BelongsToMany
    {
        return $this->belongsToMany(Questionaire::class,'departments_questionaires')->withTimestamps();
    }

}
