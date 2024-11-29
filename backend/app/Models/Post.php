<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;


    protected $guarded = [];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            // Xử lý tạo slug cho bài viết khi tạo mới
            $originalSlug = Str::slug($post->title);
            $slug = $originalSlug;
            $count = 1;

            // Nếu slug đã tồn tại, thêm số đếm vào cuối slug để đảm bảo tính duy nhất
            while (Post::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $post->slug = $slug;
        });

        static::updating(function ($post) {

            if ($post->isDirty('title')) {
                $originalSlug = Str::slug($post->title);
                $slug = $originalSlug;
                $count = 1;

                while (Post::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }

                $post->slug = $slug;
            }
        });
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'posts_id');
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tags_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function savedByUsers()
    {
        return $this->hasMany(\App\Models\SavePost::class, 'posts_id');
    }
}
