<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ActivityType;
use App\Models\ActivityBasic;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityBasicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ActivityBasic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        $startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp());
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addHour();
        $user = User::inRandomOrder()->first();

        return [
            'activity_type_id' => ActivityType::factory(),
            'theme' => "Theme:{$faker->word(5)}",
            'description' => $faker->paragraph(2, false),
            'place' => $faker->word(2),
            'apply_limit' => $faker->randomNumber(2, false),
            'apply_sdate' => $startDate,
            'apply_edate' => $endDate,
            'apply_state' => $faker->boolean(),
            'sdate' => $startDate,
            'edate' => $endDate,
            'CreateID' => $user->id,
            'UpdateID' => $user->id,
        ];
    }
}
