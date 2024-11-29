<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tags_id')->constrained('tags')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_tags_id_foreign');
            $table->dropForeign('posts_users_id_foreign');
            $table->dropColumn('users_id');
        });
    }
};
