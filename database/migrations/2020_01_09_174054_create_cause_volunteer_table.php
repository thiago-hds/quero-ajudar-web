<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCauseVolunteerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cause_volunteer', function (Blueprint $table) {
            $table->bigInteger('cause_id')->unsigned();
            $table->bigInteger('volunteer_id')->unsigned();
            $table->primary(['cause_id','volunteer_id']);
            $table->foreign('cause_id')->references('id')->on('causes')->onDelete('restrict');
            $table->foreign('volunteer_id')->references('user_id')->on('volunteers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cause_volunteer');
    }
}
