<?php

namespace App\Models;

use App\Models\User;
use App\Models\Evaluatee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['department'];

    public function users()
    {
      return $this->morphedByMany(User::class, 'departmentable')->withTimestamps();
    }

    public function evaluatees()
    {
        return $this->morphedByMany(Evaluatee::class,'departmentable')->withTimestamps();
    }
}
