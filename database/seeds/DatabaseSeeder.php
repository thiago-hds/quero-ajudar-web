<?php

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
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(OrganizationTypesTableSeeder::class);
        $this->call(CausesTableSeeder::class);
        //$this->call(OrganizationsTableSeeder::class);
        $this->call(SkillsTableSeeder::class);
        //$this->call(VacanciesTableSeeder::class);
    }
}
