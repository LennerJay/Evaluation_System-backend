<?php

namespace App\Models;

use App\Models\User;
use App\Models\Klass;
use App\Models\KlassSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SectionYear extends Model
{
    use HasFactory;

    protected $fillable = ['s_y'];
    // protected $hidden = ['pivot'];

    public function sectionYearsPerUser():BelongsToMany
    {
        return $this->belongsToMany(User::class,'section_per_users','section_year_id','user_id')->withTimestamps();
    }

    public function klasses(): BelongsToMany
    {
        return $this->belongsToMany(Klass::class,'klass_sections','section_year_id','klass_id')
        ->withPivot(['time','day']);
        // ->withTimestamps();
    }

    public function klassSections(): HasMany
    {
        return $this->hasMany(KlassSection::class,'section_year_id','id')->withTimestamps();
    }


}
