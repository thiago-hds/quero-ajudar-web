<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerFavoriteOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_favorite_organization', function (Blueprint $table) {
            $table->bigInteger('volunteer_id')->unsigned();
            $table->bigInteger('organization_id')->unsigned();
            $table->primary(['volunteer_id','organization_id'],'volunteer_favorite_organization_primary');
            $table->foreign('volunteer_id')->references('user_id')->on('volunteers')->onDelete('cascade');
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
        Schema::dropIfExists('volunteer_favorite_organization');
    }
}
