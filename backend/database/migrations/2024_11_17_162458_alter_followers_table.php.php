<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('followers', function (Blueprint $table) {

            $table->foreignId('follower_id')->constrained('users');
            $table->foreignId('following_id')->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::table('followers', function (Blueprint $table) {

            $table->dropForeign('followers_follower_id_foreign');
            $table->dropForeign('followers_following_id_foreign');
            $table->dropColumn(['follower_id', 'following_id']);
        });
    }
};
