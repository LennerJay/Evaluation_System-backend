<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Rating;
use App\Models\Question;
use App\Models\UserInfo;
use App\Models\Evaluatee;
use App\Models\Department;
use App\Models\SectionYear;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
        'password',
    ];
    public $timestamps = false;
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

    public function questions(): HasManyThrough
    {
        return $this->hasManyThrough(Question::class,Rating::class,'evaluator_id','id','id_number','question_id');
    }


    public function departments():MorphToMany
    {
        return $this->morphToMany(Department::class, 'departmentable')
            ->withTimestamps();
    }


    public function evaluatees():BelongsToMany
    {
        return $this->belongsToMany(Evaluatee::class,'evaluatees_users','user_id','evaluatee_id')
                    ->withPivot('is_done')
                    ->withTimestamps();

    }

    public function role(): BelongsTo
    {
        return $this->BelongsTo(Role::class);
    }

    public function sectionYearsPerUser():BelongsToMany
    {
        return $this->belongsToMany(SectionYear::class,'section_per_users','user_id','section_year_id')->withTimestamps();
    }

}
