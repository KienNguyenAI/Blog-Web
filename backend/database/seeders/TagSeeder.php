<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            ['name' => 'Quan điểm - Tranh luận'],
            ['name' => 'Chính trị - Xã hội'],
            ['name' => 'Kinh tế - Thị trường'],
            ['name' => 'Văn hóa - Giải trí'],
            ['name' => 'Giáo dục - Đào tạo'],
            ['name' => 'Sức khỏe - Y tế'],
            ['name' => 'Môi trường - Thiên nhiên'],
            ['name' => 'Công nghệ - Đổi mới'],
            ['name' => 'Lịch sử - Di sản'],
            ['name' => 'Du lịch - Khám phá'],
            ['name' => 'Sáng tạo - Khởi nghiệp'],
            ['name' => 'Thể thao - Giải trí'],
            ['name' => 'Phong cách sống'],
        ]);
    }
}
