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
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('skill_id');
            $table->text('story');
            $table->json('challenges')->nullable();
            $table->json('interaction_data')->nullable();
            $table->integer('progress_percentage')->nullable();
            $table->timestamps();
        
            $table->foreign('child_id')->references('id')->on('children_profiles')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
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
