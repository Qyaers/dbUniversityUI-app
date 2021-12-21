<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturesSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures_subjects', function (Blueprint $table) {
            $table->unsignedBigInteger("lecturer_id");
            $table->unsignedBigInteger("subject_id");

            $table->foreign("lecturer_id")->references("id")->on("lecturers");
            $table->foreign("subject_id")->references("id")->on("subjects");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lectures_subjects');
    }
}
