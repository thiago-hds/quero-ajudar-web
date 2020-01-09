<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillVolunteerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_volunteer', function (Blueprint $table) {
            $table->bigInteger('skill_id')->unsigned();
            $table->bigInteger('volunteer_id')->unsigned();
            $table->primary(['skill_id','volunteer_id']);
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('restrict');
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
        Schema::dropIfExists('skill_volunteer');
    }
}
