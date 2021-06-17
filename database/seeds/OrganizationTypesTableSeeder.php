<?php

use Illuminate\Database\Seeder;

class OrganizationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organization_types')->insert([
            ['id' => '1', 'name' => 'Asilo'],
            ['id' => '2', 'name' => 'Hospital'],
            ['id' => '3', 'name' => 'ONG']
        ]);
    }
}
