<?php

namespace App\Models;

use App\Models\Klass;
use App\Models\SectionYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KlassSection extends Model
{
    use HasFactory;

    public function sectionYear():BelongsTo
    {
        return $this->belongsTo(SectionYear::class);
    }

    public function klass():BelongsTo
    {
        return $this->belongsTo(Klass::class);
    }
}
