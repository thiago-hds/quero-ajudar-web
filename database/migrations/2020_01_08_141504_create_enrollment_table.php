<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollment', function (Blueprint $table) {
            $table->bigInteger('voluntary_id')->unsigned();
            $table->bigInteger('vacancy_id')->unsigned();
            $table->primary(['voluntary_id','vacancy_id']);
            $table->foreign('voluntary_id')->references('user_id')->on('voluntary')->onDelete('cascade');
            $table->foreign('vacancy_id')->references('id')->on('vacancy')->onDelete('restrict');
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
        Schema::dropIfExists('enrollment');
    }
}
