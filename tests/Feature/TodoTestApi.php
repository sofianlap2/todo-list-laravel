<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class TodoTestApi extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // Create a user
        $user = User::factory()->create([
            'name' => 'test33',
            'email' => 'test33@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user, null)->get("/api/todo");

        $response->assertStatus(200);
    }
}
