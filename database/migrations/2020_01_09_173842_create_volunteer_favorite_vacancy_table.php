<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerFavoriteVacancyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_favorite_vacancy', function (Blueprint $table) {
            $table->bigInteger('volunteer_id')->unsigned();
            $table->bigInteger('vacancy_id')->unsigned();
            $table->primary(['volunteer_id','vacancy_id'],'volunteer_favorite_vacancy_primary');
            $table->foreign('volunteer_id')->references('user_id')->on('volunteers')->onDelete('cascade');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');
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
        Schema::dropIfExists('volunteer_favorite_vacancy');
    }
}
