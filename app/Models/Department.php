<?php

namespace App\Models;


use App\Models\Evaluatee;
use App\Models\SectionYear;
use App\Models\EvaluateeDepartment;
use App\Models\SectionYearDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $hidden = ['updated_at', 'created_at'];

    public function sectionYears(): BelongsToMany
    {
        return $this->belongsToMany(SectionYear::class,'section_year_departments','department_id','section_year_id')
        ->withTimestamps();;
    }

    public function evaluatees():BelongsToMany
    {
        return $this->belongsToMany(Evaluatee::class,'section_year_departments','department_id','evaluatee_id')
                     ->withTimestamps();;
    }

    public function sectionYearDepartments():HasMany
    {
        return $this->hasMany(SectionYearDepartment::class);
    }

}
