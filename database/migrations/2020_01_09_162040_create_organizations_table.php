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
            $table->string('email');
            $table->string('website')->nullable();
            $table->text('description');
            $table->string('logo')->nullable();
            $table->boolean('status')->default(\App\Enums\StatusType::ACTIVE);
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
