<?php

use App\Enums\LocationType;
use Illuminate\Database\Seeder;

class VacanciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        factory(App\Vacancy::class, 100)->create([
            'location_type' => LocationType::SPECIFIC_ADDRESS
            ])->each(function ($vacancy) {
            // Seed the relation with one address
            $address = factory(App\Address::class)->make();
            $vacancy->address()->save($address);

        });
    }
}
