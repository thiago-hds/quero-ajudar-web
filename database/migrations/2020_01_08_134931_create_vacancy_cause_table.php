<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyCauseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancy_cause', function (Blueprint $table) {
            $table->bigInteger('vacancy_id')->unsigned();
            $table->bigInteger('cause_id')->unsigned();
            $table->primary(['vacancy_id','cause_id']);
            $table->foreign('vacancy_id')->references('id')->on('vacancy')->onDelete('cascade');
            $table->foreign('cause_id')->references('id')->on('cause')->onDelete('restrict');
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
        Schema::dropIfExists('vacancy_cause');
    }
}
