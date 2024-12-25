<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'post_id',
    //     'user_id',
    //     'content',
    //     'status',
    //     'parent_id'
    // ];

    protected $guarded = [];
    // Quan hệ với bảng users (1 user có nhiều bình luận)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng posts (1 post có nhiều bình luận)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Quan hệ với bảng comments (1 comment có thể có nhiều reply)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Quan hệ với comment cha (1 comment có thể thuộc về 1 comment khác)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
