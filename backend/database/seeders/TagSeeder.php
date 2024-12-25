<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'Quan điểm - Tranh luận',
            'Khoa học - Công nghệ',
            'Tài chính',
            'Lịch Sử',
            'Movie',
            'Phát triển bản thân',
            'Game',
            'Du lịch',
            'Thể thao',
            'Âm nhạc',
            

        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag)
            ]);
        }
    }
}