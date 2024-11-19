<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo người dùng
        $user = DB::table('users')->insertGetId([
            'avatar' => '/avatars/admin.webp',
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'roles_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users_bio')->insert([
            'users_id' => $user,
            'bg_image' => '',
            'bio_description' => 'Quản trị viên hệ thống',
            'dob' => null,
            'gender' => 'male',
            'phone' => '123456789',
            'address' => '123 Admin Street',
            'current_job' => 'Administrator',
            'education' => 'University',
            'current_location' => 'Hà Nội',
            'hometown' => 'Hà Nội',
            'updated_at' => now(),
            'created_at' => now(),
        ]);
    }
}
