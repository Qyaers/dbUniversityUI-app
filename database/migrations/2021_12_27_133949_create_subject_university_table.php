<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectUniversityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_university', function (Blueprint $table) {
            $table->unsignedBigInteger("university_id");
            $table->unsignedBigInteger("subject_id");

            $table->primary(['university_id','subject_id']);
            $table->foreign("university_id")->references("id")->on("universities")->onDelete("cascade");
            $table->foreign("subject_id")->references("id")->on("subjects")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_university');
    }
}
