<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users_bio', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users_bio', function (Blueprint $table) {
            $table->dropForeign('users_bio_users_id_foreign');
            $table->dropColumn('users_id');
        });
    }
};
