<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('volunteer_user_id')->unsigned();
            $table->bigInteger('vacancy_id')->unsigned();
            $table->unique(['volunteer_user_id','vacancy_id']);
            $table->foreign('volunteer_user_id')->references('user_id')->on('volunteers')->onDelete('cascade');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('restrict');
            $table->boolean('status')->default(\App\Enums\StatusType::ACTIVE);
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
        Schema::dropIfExists('applications');
    }
}
