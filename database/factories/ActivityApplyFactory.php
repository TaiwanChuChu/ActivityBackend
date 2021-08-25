<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ActivityApply;
use App\Models\ActivityBasic;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityApplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ActivityApply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'activity_id' => ActivityBasic::factory(),
            'user_id' =>  User::inRandomOrder()->first()->id,
            'CreateID' => User::inRandomOrder()->first()->id,
            'UpdateID' => User::inRandomOrder()->first()->id,
        ];
    }
}
