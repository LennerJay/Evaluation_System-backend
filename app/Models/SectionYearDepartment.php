<?php

namespace App\Models;

use App\Models\User;
use App\Models\Klass;
use App\Models\Evaluatee;
use App\Models\Department;
use App\Models\SectionYear;
use App\Models\KlassDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SectionYearDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'section_year_id'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'pivot'
    ];

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function sectionYear():BelongsTo
    {
        return $this->belongsTo(SectionYear::class);
    }

    public function evaluatees():BelongsToMany
    {
        return $this->belongsToMany(Evaluatee::class,'klass_details','s_y_d_id','evaluatee_id');
    }

    public function KlassDetails():HasMany
    {
        return $this->hasMany(KlassDetails::class,'s_y_d_id','id');
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class,'section_per_users','s_y_d_id','user_id','id','id_number')->withTimestamps();
    }
}
