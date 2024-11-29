<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            $originalSlug = Str::slug($tag->name);
            $slug = $originalSlug;
            $count = 1;

            while (Tag::where('slug', $slug)->exists()) {
                $count++;
            }

            $tag->slug = $slug;
        });


        static::updating(function ($tag) {
            if ($tag->isDirty('name')) {
                $originalSlug = Str::slug($tag->name);
                $slug = $originalSlug;
                $count = 1;

                while (Tag::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }

                $tag->slug = $slug;
            }
        });
    }
}