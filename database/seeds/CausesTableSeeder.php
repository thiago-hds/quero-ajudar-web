<?php

use Illuminate\Database\Seeder;

class CausesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('causes')->insert([
            ['id' => '1', 'name' => 'Animais'],
            ['id' => '2', 'name' => 'Artes e Cultura'],
            ['id' => '3', 'name' => 'Combate à Pobreza'],
            ['id' => '4', 'name' => 'Crianças e Jovens'],
            ['id' => '5', 'name' => 'Desempregados'],
            ['id' => '6', 'name' => 'Educação'],
            ['id' => '7', 'name' => 'Esportes'],
            ['id' => '8', 'name' => 'Idosos'],
            ['id' => '9', 'name' => 'Meio Ambiente'],
            ['id' => '10', 'name' => 'Pessoas com Deficiência'],
            ['id' => '11', 'name' => 'Saúde'],
        ]);
    }
}
