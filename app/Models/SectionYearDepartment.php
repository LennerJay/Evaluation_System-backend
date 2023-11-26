<?php

namespace App\Models;

use App\Models\Klass;
use App\Models\Department;
use App\Models\SectionYear;
use App\Models\klassSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SectionYearDepartment extends Model
{
    use HasFactory;

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function sectionYears():BelongsTo
    {
        return $this->belongsTo(SectionYear::class);
    }

    public function klassSections():HasMany
    {
        return $this->hasMany(klassSection::class);
    }

    public function klasses():BelongsToMany
    {
        return $this->belongsToMany(Klass::class,'klass_sections','s_y_id','klass_id')->withTimestamps();
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class,'section_per_users','s_y_d_id','user_id','id','id_number')->withTimestamps();
    }
}
