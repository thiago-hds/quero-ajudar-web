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
        $this->call(UsersTableSeeder::class);
        $this->call(OrganizationTypesTableSeeder::class);
        $this->call(CausesTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
    }
}
