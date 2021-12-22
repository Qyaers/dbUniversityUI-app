<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChairsUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chair_university', function (Blueprint $table) {
            $table->unsignedBigInteger("chair_id");
            $table->unsignedBigInteger("university_id");

            $table->foreign("chair_id")->references("id")->on("chairs");
            $table->foreign("university_id")->references("id")->on("universities");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chair_university');
    }
}
