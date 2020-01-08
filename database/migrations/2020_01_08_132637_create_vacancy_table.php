<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('organization_id')->unsigned();
            $table->string('name');
            $table->string('description');
            $table->enum('type',['recurrent','unique_event']);
            $table->string('tasks');
            $table->dateTime('time');
            $table->date('promotion_start_date')->nullable();
            $table->date('promotion_end_date')->nullable();
            $table->integer('enrollment_limit')->nullable();
            $table->string('image');
            $table->enum('status', ['active','inactive']);
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organization')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacancy');
    }
}
