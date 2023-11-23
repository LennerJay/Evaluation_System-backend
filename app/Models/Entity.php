<?php

namespace App\Models;

use App\Models\Evaluatee;
use App\Models\Questionaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = ['entity_name'];


    public function questionaires():BelongsToMany
    {
        return $this->belongsToMany(Questionaire::class,'entities_questionaires')->withTimestamps();
    }

    public function evaluatees(): HasMany
    {
        return $this->hasMany(Evaluatee::class);
    }
}
