<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
    protected $guarded = [];
    protected $table = 'users_bio';

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
