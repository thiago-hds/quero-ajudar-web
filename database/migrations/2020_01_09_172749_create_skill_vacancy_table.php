<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillVacancyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_vacancy', function (Blueprint $table) {
            $table->bigInteger('skill_id')->unsigned();
            $table->bigInteger('vacancy_id')->unsigned();
            $table->primary(['skill_id','vacancy_id']);
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('restrict');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');
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
        Schema::dropIfExists('skill_vacancy');
    }
}
