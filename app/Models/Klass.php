<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\Evaluatee;
use App\Models\Department;
use App\Models\SectionYear;
use App\Models\KlassSection;
use App\Models\EvaluateeDepartment;
use App\Models\SectionYearDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Klass extends Model
{
    use HasFactory;
    // protected $hidden = ['pivot'];

    protected $hidden = ['updated_at', 'created_at'];

    public function subject():BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function evaluateeDepartment():BelongsTo
    {
        return $this->belongsTo(EvaluateeDepartment::class);
    }

    public function klassSections():HasMany
    {
        return $this->hasMany(KlassSection::class);
    }

    public function sectionYearDepartment():BelongsToMany
    {
        return $this->belongsToMany(SectionYearDepartment::class,'klass_sections','klass_id','s_y_d_id')
        ->withPivot(['time','day'])
        ->withTimestamps();
    }

}
