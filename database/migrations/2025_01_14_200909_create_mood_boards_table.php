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
        Schema::create('mood_boards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_profile_id')->constrained('children_profiles')->onDelete('cascade'); // Relationship with child profiles
            $table->string('image_path'); // Path to the image
            $table->string('description')->nullable(); // Optional description of the image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mood_boards');
    }
};
