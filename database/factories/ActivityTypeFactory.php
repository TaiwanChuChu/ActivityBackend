<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ActivityType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ActivityType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();

        return [
            'type_code' => $this->faker->words(1, true),
            'type_name' => $this->faker->name(),
            'state' => $this->faker->boolean(),
            'CreateID' => $user->id,
            'UpdateID' => $user->id,
        ];
    }
}
