<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_tags', function (Blueprint $table) {
            $table->foreignId('posts_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('tags_id')->constrained('tags')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('post_tags', function (Blueprint $table) {
            $table->dropForeign('post_tags_posts_id_foreign');
            $table->dropForeign('post_tags_tags_id_foreign');
            $table->dropColumn(['posts_id', 'tags_id']);
        });
    }
};
