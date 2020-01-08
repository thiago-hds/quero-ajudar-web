<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPhoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_phone', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('phone_id')->unsigned();
            $table->primary('user_id', 'phone_id');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('phone_id')->references('id')->on('phone')->onDelete('cascade');
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
        Schema::dropIfExists('user_phone');
    }
}
