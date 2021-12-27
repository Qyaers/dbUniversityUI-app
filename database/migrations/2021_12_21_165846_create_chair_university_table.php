<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChairUniversityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chair_university', function (Blueprint $table) {
            $table->unsignedBigInteger("university_id");
            $table->unsignedBigInteger("chair_id");

            $table->primary(["chair_id", "university_id"]);
            $table->foreign("chair_id")->references("id")
                ->on("chairs")->onDelete('cascade');
            $table->foreign("university_id")->references("id")
                ->on("universities")->onDelete('cascade');
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
