<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('organization_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->enum('profile',['admin','organization','voluntary']);
            $table->date('birth');
            $table->enum('status',['active,inactive']);
            $table->foreign('organization_id')->references('id')->on('organization')->onDelete('restrict');
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
        Schema::dropIfExists('user');
    }
}
