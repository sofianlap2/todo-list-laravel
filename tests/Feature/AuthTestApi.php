<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTestApi extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $user = User::factory()->create([
            'name' => 'test22',
            'email' => 'test22@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/api/login', [
            'email' => 'test22@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }
}
