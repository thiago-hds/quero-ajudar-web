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
            ['id' => '1', 'name' => 'Animais','fontawesome_icon_unicode' => '&#xf6d3;'],
            ['id' => '2', 'name' => 'Artes e Cultura', 'fontawesome_icon_unicode' => '&#xf1fc;'],
            ['id' => '3', 'name' => 'Combate à Pobreza', 'fontawesome_icon_unicode' => '&#xf4c4;'],
            ['id' => '4', 'name' => 'Crianças e Jovens', 'fontawesome_icon_unicode' => '&#xf1ae;'],
            ['id' => '5', 'name' => 'Desempregados', 'fontawesome_icon_unicode' => '&#xf508;'],
            ['id' => '6', 'name' => 'Educação', 'fontawesome_icon_unicode' => '&#xf304;'],
            ['id' => '7', 'name' => 'Esportes', 'fontawesome_icon_unicode' => '&#xf1e3;'],
            ['id' => '8', 'name' => 'Idosos', 'fontawesome_icon_unicode' => ';'],
            ['id' => '9', 'name' => 'Meio Ambiente', 'fontawesome_icon_unicode' => '&#xf1bb;'],
            ['id' => '10', 'name' => 'Pessoas com Deficiência', 'fontawesome_icon_unicode' => '&#xf29d;'],
            ['id' => '11', 'name' => 'Saúde', 'fontawesome_icon_unicode' => '&#xf21e;'],
        ]);
    }
}
