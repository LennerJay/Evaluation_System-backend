<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\Evaluatee;
use App\Models\SectionYear;
use App\Models\KlassSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Klass extends Model
{
    use HasFactory;
    // protected $hidden = ['pivot'];

    public function subject():BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function evaluatee():BelongsTo
    {
        return $this->belongsTo(Evaluatee::class);
    }

    public function klassSections():HasMany
    {
        return $this->hasMany(KlassSection::class);
    }

    public function sectionYears():BelongsToMany
    {
        return $this->belongsToMany(SectionYear::class,'klass_sections','klass_id','section_year_id')
        ->withPivot(['time','day'])
        ->withTimestamps();
    }

}
