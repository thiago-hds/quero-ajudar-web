<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('organization_type_id')->unsigned();
            $table->string('name');
            $table->string('website');
            $table->string('description');
            $table->string('logo');
            $table->enum('status', ['active','inactive']);
            $table->timestamps();
            $table->foreign('organization_type_id')->references('id')->on('organization_types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}