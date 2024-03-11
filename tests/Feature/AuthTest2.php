<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest2 extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $user = User::factory()->create([
            'name' => 'test11',
            'email' => 'test11@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test11@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/todo');
        $this->assertAuthenticatedAs($user);

        // Create a new post
        $response = $this->get('todo');

        // Assert the post was created successfully
        $response->assertStatus(200);

        $response2 = $this->post('todo', [
            'title' => 'testingtitle'
        ]);

        $response2->assertStatus(302);
        $this->assertDatabaseHas('todo_models', [
            'title' => 'testingtitle',
        ]);
    }
}
