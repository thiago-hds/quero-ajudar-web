<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('name');
            $table->text('description');
            $table->string('type');
            $table->string('tasks')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->boolean('status')->default(\App\Enums\StatusType::ACTIVE);

            // hours
            $table->date('date')->nullable()->default(null);
            $table->time('start_time')->nullable()->default(null);
            $table->time('end_time')->nullable()->default(null);

            // location
            $table->string('location_type');

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
        Schema::dropIfExists('vacancies');
    }
}
