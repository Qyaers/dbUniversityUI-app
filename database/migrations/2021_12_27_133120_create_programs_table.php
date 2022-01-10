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
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('lecturer_id')->nullable();
            $table->integer("hours");

            $table->foreign("course_id")->references("id")->on("courses")->onDelete("cascade");
            $table->foreign("subject_id")->references("id")->on("subjects")->onDelete("cascade");;
            $table->foreign("lecturer_id")->references("id")->on("lecturers")->onDelete("set null");;
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
