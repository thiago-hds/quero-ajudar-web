<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCauseVacancyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cause_vacancy', function (Blueprint $table) {
            $table->bigInteger('cause_id')->unsigned();
            $table->bigInteger('vacancy_id')->unsigned();
            $table->primary(['cause_id','vacancy_id']);
            $table->foreign('cause_id')->references('id')->on('causes')->onDelete('restrict');
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
        Schema::dropIfExists('cause_vacancy');
    }
}
