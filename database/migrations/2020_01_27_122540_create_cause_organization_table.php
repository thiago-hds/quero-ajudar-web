<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCauseOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cause_organization', function (Blueprint $table) {
            $table->bigInteger('cause_id')->unsigned();
            $table->bigInteger('organization_id')->unsigned();
            $table->primary(['cause_id','organization_id']);
            $table->foreign('cause_id')->references('id')->on('causes')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
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
        Schema::dropIfExists('cause_organization');
    }
}
