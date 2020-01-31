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
            ['id' => '1', 'name' => 'Artes'],
            ['id' => '2', 'name' => 'Computadores/Tecnologia'],
            ['id' => '3', 'name' => 'Comunicação'],
            ['id' => '4', 'name' => 'Dança/Música'],
            ['id' => '5', 'name' => 'Direito'],
            ['id' => '6', 'name' => 'Esportes'],
            ['id' => '7', 'name' => 'Finanças'],
            ['id' => '8', 'name' => 'Saúde'],
        ]);
    }
}
