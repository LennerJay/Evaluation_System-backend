<?php

namespace App\Models;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KlassSection extends Model
{
    use HasFactory;

    public function schedule():HasOne
    {
        return $this->hasOne(Schedule::class);
    }
}
