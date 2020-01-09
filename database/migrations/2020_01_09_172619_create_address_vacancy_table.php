<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressVacancyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_vacancy', function (Blueprint $table) {
            $table->bigInteger('address_id')->unsigned();
            $table->bigInteger('vacancy_id')->unsigned();
            $table->primary(['address_id','vacancy_id']);
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
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
        Schema::dropIfExists('address_vacancy');
    }
}
