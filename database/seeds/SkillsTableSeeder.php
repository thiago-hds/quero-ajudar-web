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
            ['id' => '1', 'name' => 'Artes', 'fontawesome_icon_unicode' => 'f1fc'],
            ['id' => '2', 'name' => 'Computadores/Tecnologia', 'fontawesome_icon_unicode' => 'f109'],
            ['id' => '3', 'name' => 'Comunicação', 'fontawesome_icon_unicode' => 'f0a1'],
            ['id' => '4', 'name' => 'Dança/Música', 'fontawesome_icon_unicode' => 'f001'],
            ['id' => '5', 'name' => 'Direito', 'fontawesome_icon_unicode' => 'f0e3'],
            ['id' => '6', 'name' => 'Esportes', 'fontawesome_icon_unicode' => 'f1e3'],
            ['id' => '7', 'name' => 'Finanças', 'fontawesome_icon_unicode' => 'f155'],
            ['id' => '8', 'name' => 'Saúde', 'fontawesome_icon_unicode' => 'f21e'],
            ['id' => '9', 'name' => 'Veterinária', 'fontawesome_icon_unicode' => 'f6d3'],
        ]);
    }
}
