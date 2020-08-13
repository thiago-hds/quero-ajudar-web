<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('organization_id')->unsigned()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email'); 
            $table->string('password');
            $table->tinyInteger('profile')->default(0);
            $table->date('date_of_birth')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('restrict');
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
        Schema::dropIfExists('users');
    }
}
