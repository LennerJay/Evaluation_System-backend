<?php

namespace App\Models;

use App\Models\Klass;
use App\Models\Evaluatee;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EvaluateeDepartment extends Model
{
    use HasFactory;

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function evaluatee():BelongsTo
    {
        return $this->belongsTo(Evaluatee::class);
    }

    public function klasses():HasMany
    {
        return $this->hasMany(Klass::class);
    }

    public function subjects():BelongsToMany
    {
        return $this->belongsToMany(Subject::class,'klasses','e_d_id','id')->withTimestamps();
    }
}
