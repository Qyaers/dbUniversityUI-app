<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('subject_id')->default(0);
            $table->unsignedBigInteger('lecturer_id')->default(0);
            $table->integer("hours");

            $table->foreign("course_id")->references("id")->on("courses");
            $table->foreign("subject_id")->references("id")->on("subjects");
            $table->foreign("lecturer_id")->references("id")->on("lecturers");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
