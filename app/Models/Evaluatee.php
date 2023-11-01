<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\Rating;
use App\Models\Department;
use App\Models\Questionaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evaluatee extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $hidden = ['pivot'];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }


    public function departments():MorphToMany
    {
        return $this->morphToMany(Department::class,'departmentable')->withTimestamps();
    }


    public function questionaires():BelongsToMany
    {
        return $this->belongsToMany(Questionaire::class,'evaluatees_questionaires')->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'evaluatees_users','evaluatee_id','user_id')->withTimestamps();
    }
    public function roles(): MorphToMany
    {
        return $this->morphToMany(Role::class,'roleable')->withTimestamps();
    }
}