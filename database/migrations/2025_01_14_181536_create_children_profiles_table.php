<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('children_profiles', function (Blueprint $table) {
                $table->id('child_id');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('name', 100);
                $table->date('date_of_birth');
                $table->text('hobbies')->nullable();
                $table->string('dream_job', 100)->nullable();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children_profiles');
    }
};
