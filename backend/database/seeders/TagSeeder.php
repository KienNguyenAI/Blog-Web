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
            'Chính trị - Xã hội',
            'Kinh tế - Thị trường',
            'Văn hóa - Giải trí',
            'Giáo dục - Đào tạo',
            'Sức khỏe - Y tế',
            'Môi trường - Thiên nhiên',
            'Công nghệ - Đổi mới',
            'Lịch sử - Di sản',
            'Du lịch - Khám phá',
            'Sáng tạo - Khởi nghiệp',
            'Thể thao - Giải trí',
            'Phong cách sống'
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag)
            ]);
        }
    }
}
