<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follower extends Model
{
    use HasFactory;


    protected $guarded = [];
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }


    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
