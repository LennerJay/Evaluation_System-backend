<?php

namespace App\Models;

use App\Models\Questionaire;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluateeUser extends Pivot
{
   protected $table = 'evaluatees_users';

   public function questionaire():BelongsTo
   {
        return $this->belongsTo(Questionaire::class);
   }
}
