<?php

namespace Database\Seeders;

use App\Vacancy;
use Illuminate\Database\Seeder;

class VacanciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vacancy::factory(20)->create();
    }
}
