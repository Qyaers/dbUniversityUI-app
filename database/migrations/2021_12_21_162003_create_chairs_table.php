<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chairs', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unique("name");
            $table->foreignId("faculty_id")->nullable()->constrained("faculties")->cascadeOnUpdate()->nullOnDelete();
//            $table->unsignedBigInteger('faculty_id')->nullable();
//
//            $table->foreign("faculty_id")->references("id")
//                ->on("faculties");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chairs');
    }
}
