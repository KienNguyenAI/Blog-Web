<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('posts_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comments_posts_id_foreign');
            $table->dropForeign('comments_users_id_foreign');
            $table->dropColumn(['posts_id', 'users_id']);
        });
    }
};
