<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ActivityType;
use App\Models\ActivityApply;
use App\Models\ActivityBasic;
use Illuminate\Database\Seeder;
use Database\Factories\ActivityTypeFactory;
use Database\Factories\ActivityApplyFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // ActivityType::factory(2)->has(User::factory()->count(1))->create();
        // ActivityType::factory()
        //     ->has(ActivityBasic::factory()->count(3))
        //     ->create();
        ActivityType::factory(3)->has(
            ActivityBasic::factory(3)->has(ActivityApply::factory(5))
        )->create();

        // ActivityBasic::factory(30)->for(ActivityType::factory())->create();
        // ActivityType::newFactory(2)->has(ActivityBasic::factory(3))->create();
    }
}
