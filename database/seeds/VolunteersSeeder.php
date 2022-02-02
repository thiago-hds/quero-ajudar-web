<?php

namespace Database\Seeders;

use App\Volunteer;
use Illuminate\Database\Seeder;

class VolunteersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Volunteer::factory(20)->create();
    }
}
