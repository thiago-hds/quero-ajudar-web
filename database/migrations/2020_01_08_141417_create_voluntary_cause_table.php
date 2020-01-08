<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoluntaryCauseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voluntary_cause', function (Blueprint $table) {
            $table->bigInteger('voluntary_id')->unsigned();
            $table->bigInteger('cause_id')->unsigned();
            $table->primary(['voluntary_id','cause_id']);
            $table->foreign('voluntary_id')->references('user_id')->on('voluntary')->onDelete('cascade');
            $table->foreign('cause_id')->references('id')->on('cause')->onDelete('restrict');
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
        Schema::dropIfExists('voluntary_cause');
    }
}
