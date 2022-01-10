<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->foreignId("course_id")->nullable()->constrained("courses")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId("university_id")->nullable()->constrained("universities")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId("chair_id")->nullable()->constrained("chairs")->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('streams');
    }
}
