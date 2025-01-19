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
        Schema::create('child_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children_profiles')->onDelete('cascade');
            $table->foreignId('visualization_id')->constrained('ai_visualizations')->onDelete('cascade');
            $table->text('response')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_interactions');
    }
};
