<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_address', function (Blueprint $table) {
            $table->bigInteger('organization_id')->unsigned();
            $table->bigInteger('address_id')->unsigned();
            $table->primary('organization_id', 'address_id');
            $table->foreign('organization_id')->references('id')->on('organization')->onDelete('cascade');
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
        Schema::dropIfExists('organization_address');
    }
}
