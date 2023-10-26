<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Rating;
use App\Models\Question;
use App\Models\UserInfo;
use App\Models\Department;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id_number';
    public $incrementing = false;
    protected $fillable = [
        'id_number',
        'name',
        'password',
    ];
    // protected $primaryKey = 'id_number';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userInfo():HasOne
    {
       return $this->hasOne(UserInfo::class,'user_id','id_number');
    }

    public function ratings():HasMany
    {
        return $this->hasMany(Rating::class,'evaluator_id','id_number');
    }
    public function questions(): HasManyThrough
    {
        return $this->hasManyThrough(Question::class,Rating::class,'evaluator_id','id','id_number','question_id');
    }
    public function departments():MorphToMany
    {
        return $this->morphToMany(Department::class, 'departmentable')
            ->withTimestamps();
    }
}
