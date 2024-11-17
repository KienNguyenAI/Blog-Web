<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_bio', function (Blueprint $table) {
            $table->id();
            $table->string('bg_image')->nullable();
            $table->text('bio_description')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('current_job')->nullable();
            $table->text('education')->nullable();
            $table->string('current_location')->nullable();
            $table->string('hometown')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_bio');
    }
};
