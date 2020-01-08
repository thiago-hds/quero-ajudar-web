<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancy_address', function (Blueprint $table) {
            $table->bigInteger('vacancy_id')->unsigned();
            $table->bigInteger('address_id')->unsigned();
            $table->primary(['vacancy_id','address_id']);
            $table->foreign('vacancy_id')->references('id')->on('vacancy')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');
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
        Schema::dropIfExists('vacancy_address');
    }
}
