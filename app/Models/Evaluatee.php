<?php

namespace App\Models;

use App\Models\User;
use App\Models\Klass;
use App\Models\Entity;
use App\Models\Rating;
use App\Models\Subject;
use App\Models\Department;
use App\Models\SectionYear;
use App\Models\KlassDetails;
use App\Models\EvaluateeDepartment;
use App\Models\SectionYearDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evaluatee extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = [
        'name',
        'entity_id',
        'job_type'
    ];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function KlassDetails(): HasMany
    {
        return $this->hasMany(KlassDetails::class);
    }

    public function SectionYearDepartments(): BelongsToMany
    {
        return $this->belongsToMany(SectionYearDepartment::class,'klass_details','evaluatee_id','s_y_d_id','id','id')
                    ->withPivot(['time','day'])
                    ->withTimestamps();
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class,'klass_details','evaluatee_id','subject_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'evaluatees_users','evaluatee_id','user_id')
                    ->withPivot(['is_done'])
                    ->withTimestamps();
    }

    public function entity():BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }


}
