<?php

namespace Database\Factories;

use App\Organization;
use App\OrganizationType;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->company(),
            'email'         => $this->faker->companyEmail(),
            'website'       => $this->faker->url(),
            'description'   => $this->faker->paragraph(),
            'logo'          => $this->faker->imageUrl(640, 480, 'animals', true),
            'status'        => \App\Enums\StatusType::ACTIVE,
            'organization_type_id' => OrganizationType::factory()
        ];
    }
}
