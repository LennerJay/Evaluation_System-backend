<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\Evaluatee;
use App\Models\SectionYearDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KlassDetails extends Model
{
    use HasFactory;

    protected $fillable=[
        's_y_d_id',
        'subject_id',
        'evaluatee_id',
        'time',
        'day',
    ];

    protected $hidden = ['created_at','updated_at'];

    public function sectionYearDepartment():BelongsTo
    {
        return $this->belongsTo(SectionYearDepartment::class, 's_y_d_id','id');
    }

    public function subject():BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function evaluatee(): BelongsTo
    {
        return $this->belongsTo(Evaluatee::class);
    }
}
