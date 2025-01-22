<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrenProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('children_profiles', function (Blueprint $table) {
            $table->id(); // Primary key, unsignedBigInteger
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->string('name', 100);
            $table->date('date_of_birth');
            $table->text('hobbies')->nullable();
            $table->string('dream_job', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('children_profiles');
    }
}
