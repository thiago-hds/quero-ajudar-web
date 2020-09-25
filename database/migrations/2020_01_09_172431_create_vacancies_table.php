<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('organization_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->tinyInteger('type');
            $table->string('tasks')->nullable();

            // periodicity
            $table->tinyInteger('periodicity')->nullable();
            $table->integer('amount_per_period')->nullable();
            $table->tinyInteger('unit_per_period')->nullable();

            // time schedule
            $table->date('date')->nullable();
            $table->time('time')->nullable();

            // location
            $table->tinyInteger('location_type');

            $table->date('promotion_start_date')->nullable();
            $table->date('promotion_end_date')->nullable();
            $table->integer('application_limit')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacancies');
    }
}
