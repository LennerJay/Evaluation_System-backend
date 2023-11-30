<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    protected $hidden = ['updated_at', 'created_at'];

    public const IS_ADMIN = 1;
    public const IS_STAFF = 2;


    public function users():HasMany
    {
        return $this->HasMany(User::class)->withTimestamps();
    }
}
