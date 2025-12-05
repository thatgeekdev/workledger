<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id','full_name','gender','date_of_birth','phone_number',
        'address','job_title','department','avatar_url','bio','status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

