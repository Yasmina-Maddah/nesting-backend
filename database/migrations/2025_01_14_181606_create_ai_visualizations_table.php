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
        Schema::create('ai_visualizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_skill_id')->constrained('child_skills')->onDelete('cascade');
            $table->text('story_text');
            $table->string('visualization_path', 255)->nullable();
            $table->text('challenges')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_visualizations');
    }
};
