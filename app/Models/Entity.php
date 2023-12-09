<?php

namespace App\Models;

use App\Models\Evaluatee;
use App\Models\Questionaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = ['entity_name'];
    protected $hidden = ['updated_at', 'created_at'];

    public function questionaires():HasMany
    {
        return $this->hasMany(Questionaire::class);
    }

    public function evaluatees(): HasMany
    {
        return $this->hasMany(Evaluatee::class);
    }
}
