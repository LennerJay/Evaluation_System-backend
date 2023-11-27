<?php

namespace App\Models;

use App\Models\Klass;
use App\Models\Evaluatee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $hidden = ['updated_at', 'created_at'];

    public function klasses():HasMany
    {
        return $this->hasMany(Klass::class);
    }

    public function evaluatees():BelongsToMany
    {
        return $this->belongsToMany(Evaluatee::class,'klasses','subject_id','evaluatee_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

}
