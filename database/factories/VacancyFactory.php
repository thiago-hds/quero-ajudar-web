<?php

namespace Database\Factories;

use App\Enums\LocationType;
use App\Enums\RecurrenceType;
use App\Enums\StatusType;
use App\Organization;
use App\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vacancy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organization_id' => Organization::factory(),
            'name' => $this->faker->jobTitle(),
            'description' => $this->faker->text(),
            'type' => RecurrenceType::UNIQUE_EVENT,
            'tasks' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),
            'status' => StatusType::ACTIVE,
            'location_type' => LocationType::ORGANIZATION_ADDRESS,
        ];
    }
}
