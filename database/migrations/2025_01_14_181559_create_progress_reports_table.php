<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressReportsTable extends Migration
{
    public function up()
    {
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->id(); // Primary key, unsignedBigInteger
            $table->foreignId('child_id')->constrained('children_profiles')->onDelete('cascade'); // Foreign key to children_profiles table
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade'); // Foreign key to skills table
            $table->text('interaction_summary')->nullable();
            $table->integer('progress_score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('progress_reports');
    }
}
