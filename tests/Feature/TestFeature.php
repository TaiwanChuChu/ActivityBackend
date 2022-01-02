<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TestFeature extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['']
        );

        $response = $this->post('/api/a01/a01110/filter');

        $response->assertStatus(200);
    }
}
