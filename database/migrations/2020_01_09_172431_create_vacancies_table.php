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
            $table->string('description');
            $table->enum('type',['recurrent','unique_event']);
            $table->string('tasks')->nullable();

            // periodicity
            $table->enum('periodicity', ['daily', 'weekly', 'monthly'])->nullable();
            $table->integer('amount_per_period')->nullable();
            $table->enum('unit_per_period', ['hours', 'days'])->nullable();

            // time schedule
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();

            // location
            $table->enum('location_type', ['organization_address', 'specific_address', 'remote', 'negotiable']);

            $table->date('promotion_start_date')->nullable();
            $table->date('promotion_end_date')->nullable();
            $table->integer('enrollment_limit')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active','inactive']);
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
