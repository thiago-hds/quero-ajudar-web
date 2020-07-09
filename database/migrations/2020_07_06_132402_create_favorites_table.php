<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('volunteer_id')->unsigned();
            $table->morphs('favoritable');
            $table->foreign('volunteer_id')->references('user_id')->on('volunteers')->onDelete('cascade');
            $table->unique(['volunteer_id', 'favoritable_id', 'favoritable_type']);
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
        Schema::table('favorites', function (Blueprint $table) {
            Schema::dropIfExists('favorites');
        });
    }
}
