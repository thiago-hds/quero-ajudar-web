<?php

namespace Database\Factories;

use App\Enums\ProfileType;
use App\User;
use App\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Volunteer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create([
                'organization_id' => null,
                'profile' => ProfileType::VOLUNTEER
            ])
        ];
    }
}
