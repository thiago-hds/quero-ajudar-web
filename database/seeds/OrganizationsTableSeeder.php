<?php

use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->insert([
            'organization_type_id'  => 3,
            'name'                  => 'ONG Juventude Melhor',
            'email'                 => 'junvetmelhor@mail.com',
            'website'               => 'www.ongjunvetudemelhor.com.br',
            'description'           => 'A ONG juventude melhor busca ajudar jovens que vivem em situação de risco',
            'logo'                  => ''
        ]);
    }
}
