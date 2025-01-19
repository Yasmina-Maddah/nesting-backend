<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildSkillsTable extends Migration
{
    public function up()
    {
        Schema::create('child_skills', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('child_id')->constrained('children_profiles')->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('child_skills');
    }
}
