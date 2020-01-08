<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoluntarySkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voluntary_skill', function (Blueprint $table) {
            $table->bigInteger('voluntary_id')->unsigned();
            $table->bigInteger('skill_id')->unsigned();
            $table->primary(['voluntary_id','skill_id']);
            $table->foreign('voluntary_id')->references('user_id')->on('voluntary')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skill')->onDelete('restrict');
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
        Schema::dropIfExists('voluntary_skill');
    }
}
