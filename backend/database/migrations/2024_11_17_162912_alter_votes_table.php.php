<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('posts_id')->constrained('posts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropForeign('votes_users_id_foreign');
            $table->dropForeign('votes_posts_id_foreign');
            $table->dropColumn(['users_id', 'posts_id']);
        });
    }
};
