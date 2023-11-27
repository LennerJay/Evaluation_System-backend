<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'mobile_number',
        'course',
        'email',
        'email_verified_at',
    ];

    protected $hidden = ['updated_at', 'created_at'];

    public function user()
    {
       return $this->belongsTo(User::class,'id_number','user_id');
    }
}
