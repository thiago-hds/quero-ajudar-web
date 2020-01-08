<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoluntaryFavoriteOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voluntary_favorite_organization', function (Blueprint $table) {
            $table->bigInteger('voluntary_id')->unsigned();
            $table->bigInteger('organization_id')->unsigned();
            $table->primary(['voluntary_id','organization_id'],'voluntary_favorite_organization_primary');
            $table->foreign('voluntary_id')->references('user_id')->on('voluntary')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organization')->onDelete('cascade');
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
        Schema::dropIfExists('voluntary_favorite_organization');
    }
}
