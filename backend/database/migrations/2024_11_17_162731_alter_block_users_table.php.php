<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('block_users', function (Blueprint $table) {
            $table->foreignId('block_users')->constrained('users')->onDelete('cascade');
            $table->foreignId('blocked_by')->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('block_users', function (Blueprint $table) {
            $table->dropForeign('block_users_block_users_foreign');  // Xóa khóa ngoại 'block_users'
            $table->dropForeign('block_users_blocked_by_foreign');   // Xóa khóa ngoại 'blocked_by'
            $table->dropColumn(['block_users', 'blocked_by']);
        });
    }
};
