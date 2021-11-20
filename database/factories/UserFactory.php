<?php

namespace Database\Factories;

use App\Organization;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email'     => $this->faker->unique()->safeEmail(),
            'password'  => bcrypt('123123'),
            'date_of_birth' => $this->faker->date('d/m/Y'),
            'profile'   => \App\Enums\ProfileType::ORGANIZATION,
            'organization_id' => Organization::factory(),
            'status'    => \App\Enums\StatusType::ACTIVE,
        ];
    }
}
