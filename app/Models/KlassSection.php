<?php

namespace App\Models;

use App\Models\User;
use App\Models\Klass;
use App\Models\Department;
use App\Models\SectionYearDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class klassSection extends Model
{
    use HasFactory;

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class,'section_per_users','klass_section_id','user_id','id','id_number')
                    ->withTimestamps();;
    }

    public function sectionYearDepartment():BelongsTo
    {
        return $this->belongsTo(SectionYearDepartment::class);
    }

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function klass():BelongsTo
    {
        return $this->belongsTo(Klass::class);
    }
}
