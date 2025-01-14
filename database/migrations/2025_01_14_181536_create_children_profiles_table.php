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
            $table->id();
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('profile_photo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->date('date_of_birth')->nullable(); // Added date_of_birth
            $table->text('hobbies')->nullable(); // Added hobbies (JSON-encoded)
            $table->string('dream_career')->nullable(); // Added dream_career
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
