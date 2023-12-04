<?php

namespace App\Models;


use App\Models\Department;
use App\Models\SectionYearDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SectionYear extends Model
{
    use HasFactory;

    protected $fillable = ['s_y'];
    // protected $hidden = ['pivot'];

    protected $hidden = ['updated_at', 'created_at'];

    public function sectionYearDepartments():HasMany
    {
        return $this->hasMany(SectionYearDepartment::class,'section_year_id','id');
    }

    public function departments():BelongsToMany
    {
        return $this->belongsToMany(Department::class,'section_year_departments','section_year_id','department_id')
                    ->withTimestamps();
    }

    public function evaluatees():BelongsToMany
    {
        return $this->belongsToMany(Evaluatee::class,'section_year_departments','section_year_id','evaluatee_id')->withTimestamps();
    }
}
