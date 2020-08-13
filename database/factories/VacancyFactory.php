<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vacancy;
use App\Address;
use App\Enums\RecurrenceType;
use App\Enums\StatusType;
use Faker\Generator as Faker;

$factory->define(Vacancy::class, function (Faker $faker) {
    return [
        'organization_id'       => 1,
        'name'                  => $faker->company,
        'description'           => $faker->text,
        'type'                  => RecurrenceType::UNIQUE_EVENT,
        'tasks'                 => 'asd',
        'image'                 => 'logo/145549202003075e63b5f5d1ef3.jpeg',
        'status'                => StatusType::ACTIVE
    ];
});

$factory->define(Address::class, function (Faker $faker) {
    return [
        'street'        => $faker->streetAddress,
        'number'        => $faker->buildingNumber,
        'neighborhood'  => $faker->city,
        'zipcode'       => $faker->postcode,
        'city_id'       => 3106200
    ];
});
