<?php

namespace App\Models;

use App\Models\User;
use App\Models\Klass;
use App\Models\Entity;
use App\Models\Rating;
use App\Models\Subject;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evaluatee extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    // protected $hidden = ['pivot'];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function departments():MorphToMany
    {
        return $this->morphToMany(Department::class,'departmentable')->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'evaluatees_users','evaluatee_id','user_id')
                    ->withPivot('is_done')
                    ->withTimestamps();
    }

    public function subjects():BelongsToMany
    {
        return $this->belongsToMany(Subject::class,'Klasses','evaluatee_id','subject_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function klasses(): HasMany
    {
        return $this->hasMany(Klass::class);
    }

    public function entity():BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

}
