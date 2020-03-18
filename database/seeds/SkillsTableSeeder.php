<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            ['id' => '1', 'name' => 'Artes', 'fontawesome_icon_unicode' => '&#xf1fc;'],
            ['id' => '2', 'name' => 'Computadores/Tecnologia', 'fontawesome_icon_unicode' => '&#xf109;'],
            ['id' => '3', 'name' => 'Comunicação', 'fontawesome_icon_unicode' => '&#xf0a1;'],
            ['id' => '4', 'name' => 'Dança/Música', 'fontawesome_icon_unicode' => '&#xf001;'],
            ['id' => '5', 'name' => 'Direito', 'fontawesome_icon_unicode' => '&#xf0e3;'],
            ['id' => '6', 'name' => 'Esportes', 'fontawesome_icon_unicode' => '&#xf1e3;'],
            ['id' => '7', 'name' => 'Finanças', 'fontawesome_icon_unicode' => '&#xf155;'],
            ['id' => '8', 'name' => 'Saúde', 'fontawesome_icon_unicode' => '&#xf21e;'],
            ['id' => '9', 'name' => 'Veterinária', 'fontawesome_icon_unicode' => '&#xf6d3;'],
        ]);
    }
}
