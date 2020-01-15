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
        DB::table('organization_types')->insert(
            ['name'      => 'Asilo'],
            ['name'      => 'Hospital'],
            ['name'      => 'ONG']
        );
    }
}
