<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancySkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancy_skill', function (Blueprint $table) {
            $table->bigInteger('vacancy_id')->unsigned();
            $table->bigInteger('skill_id')->unsigned();
            $table->primary(['vacancy_id','skill_id']);
            $table->foreign('vacancy_id')->references('id')->on('vacancy')->onDelete('cascade');
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
        Schema::dropIfExists('vacancy_skill');
    }
}
