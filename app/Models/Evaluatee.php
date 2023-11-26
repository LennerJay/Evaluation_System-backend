<?php

namespace App\Models;

use App\Models\User;
use App\Models\Klass;
use App\Models\Entity;
use App\Models\Rating;
use App\Models\Subject;
use App\Models\Department;
use App\Models\EvaluateeDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evaluatee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'entity_id',
        'job_type'
    ];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
    public function klasses(): HasMany
    {
        return $this->hasMany(Klass::class);
    }

    public function evaluateeDepartments():HasMany
    {
        return $this->hasMany(EvaluateeDepartment::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'evaluatees_users','evaluatee_id','user_id')
                    ->withPivot('is_done')
                    ->withTimestamps();
    }

    public function departments():BelongsToMany
    {
        return $this->belongsToMany(Department::class,'evaluatee_departments','evaluatee_id','department_id')
                    ->withTimestamps();
    }


    public function entity():BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

}
