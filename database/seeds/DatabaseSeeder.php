<?php

use Database\Seeders\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(OrganizationTypesTableSeeder::class);
        $this->call(CausesTableSeeder::class);
        $this->call(SkillsTableSeeder::class);
        $this->call(UsersSeeder::class);

        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(OrganizationsSeeder::class);
        //$this->call(VacanciesTableSeeder::class);
    }
}
